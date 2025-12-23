<?php

namespace App\Jobs;

use App\Imports\ProductsImport;
use App\Models\ProductImportLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ImportProductsJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 0;  // Unlimited timeout
    public $tries = 3;  // Retry up to 3 times if failed

    protected $filePath;
    protected $totalRows;
    protected $sessionKey;
    protected $importLogId;

    /**
     * Create a new job instance.
     */
    public function __construct($filePath, $totalRows, $sessionKey, $importLogId)
    {
        $this->filePath = $filePath;
        $this->totalRows = $totalRows;
        $this->sessionKey = $sessionKey;
        $this->importLogId = $importLogId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('=== ImportProductsJob Started ===');
        Log::info("File: {$this->filePath}");
        Log::info("Total Rows: {$this->totalRows}");
        Log::info("Session Key: {$this->sessionKey}");

        // Update import log status to processing
        $importLog = ProductImportLog::find($this->importLogId);
        $user = $importLog ? $importLog->user : null;
        // Prioritize ADMIN_EMAIL from .env, fallback to the user who started the import
        $recipientEmail = env('ADMIN_EMAIL') ?? ($user ? $user->email : null);

        if ($importLog) {
            $importLog->update([
                'status' => 'processing',
                'started_at' => now(),
            ]);

            // SEND IMPORT STARTED EMAIL
            if ($recipientEmail) {
                try {
                    \Illuminate\Support\Facades\Mail::to($recipientEmail)->send(
                        new \App\Mail\ImportStartedMail(basename($this->filePath), $this->totalRows, now())
                    );
                } catch (\Exception $e) {
                    Log::error('Failed to send Import Started Email: ' . $e->getMessage());
                }
            }
        }

        // Update cache status
        cache()->put($this->sessionKey, [
            'total' => $this->totalRows,
            'current' => 0,
            'percentage' => 0,
            'status' => 'processing'
        ], now()->addHours(24));

        try {
            // Increase memory limit for large imports
            ini_set('memory_limit', '1024M');

            // Create import instance with progress tracking
            $importWithProgress = new ProductsImport($this->totalRows, $this->sessionKey, $this->importLogId);

            // Perform the import
            Excel::import($importWithProgress, $this->filePath);

            // Mark as completed
            cache()->put($this->sessionKey, [
                'total' => $this->totalRows,
                'current' => $this->totalRows,
                'percentage' => 100,
                'status' => 'completed'
            ], now()->addHours(24));

            if ($importLog) {
                // Refresh log to get latest skipped counts from DB if ProductsImport updated it
                $importLog->refresh();

                // Handle Validation Failures (SkipsOnFailure)
                $failures = $importWithProgress->failures();
                $failedRowsCount = count($failures);
                $failedDetails = [];

                foreach ($failures as $failure) {
                    $row = $failure->row();
                    $attribute = $failure->attribute();
                    $errors = implode(', ', $failure->errors());
                    $failedDetails[] = [
                        'row' => $row,
                        'product_code' => 'N/A', // Cannot easily get original row data here without more logic
                        'reason' => "Validation Failed: {$attribute} - {$errors}"
                    ];
                }

                // Merge with existing skipped details if any
                $existingDetails = $importLog->skipped_details ?? [];
                $allDetails = array_merge($existingDetails, $failedDetails);

                $importLog->update([
                    'status' => 'completed', // Job completed, even if some rows failed
                    'completed_at' => now(),
                    'processed_rows' => $this->totalRows,
                    'failed_rows' => $failedRowsCount,
                    'skipped_details' => $allDetails, // Store failure details here
                    // 'successful_rows' logic: Total - Skipped - Failed
                    'successful_rows' => $this->totalRows - ($importLog->skipped_rows ?? 0) - $failedRowsCount,
                ]);

                // SEND IMPORT COMPLETED EMAIL
                if ($recipientEmail) {
                    try {
                        \Illuminate\Support\Facades\Mail::to($recipientEmail)->send(
                            new \App\Mail\ImportCompletedMail($importLog)
                        );
                    } catch (\Exception $e) {
                        Log::error('Failed to send Import Completed Email: ' . $e->getMessage());
                    }
                }
            }

            Log::info('=== ImportProductsJob Completed Successfully ===');
        } catch (\Exception $e) {
            Log::error('=== ImportProductsJob Failed ===');
            Log::error('Error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            // Update cache with error status
            cache()->put($this->sessionKey, [
                'total' => $this->totalRows,
                'current' => 0,
                'percentage' => 0,
                'status' => 'failed',
                'error' => $e->getMessage()
            ], now()->addHours(24));

            if ($importLog) {
                $importLog->update([
                    'status' => 'failed',
                    'completed_at' => now(),
                    'error_message' => $e->getMessage(),
                ]);

                // SEND IMPORT FAILED EMAIL
                $importLog->refresh();
                if ($recipientEmail) {
                    try {
                        \Illuminate\Support\Facades\Mail::to($recipientEmail)->send(
                            new \App\Mail\ImportCompletedMail($importLog)
                        );
                    } catch (\Exception $ex) {
                        Log::error('Failed to send Import Failed Email: ' . $ex->getMessage());
                    }
                }
            }

            throw $e;  // Re-throw to mark job as failed
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('=== ImportProductsJob Failed Permanently ===');
        Log::error('Error: ' . $exception->getMessage());

        $importLog = ProductImportLog::find($this->importLogId);
        // Prioritize ADMIN_EMAIL from .env, fallback to the user who started the import
        $recipientEmail = env('ADMIN_EMAIL');
        if (!$recipientEmail && $importLog && $importLog->user) {
             $recipientEmail = $importLog->user->email;
        }
        
        if ($importLog) {
            $importLog->update([
                'status' => 'failed',
                'completed_at' => now(),
                'error_message' => 'Job failed after ' . $this->tries . ' attempts: ' . $exception->getMessage(),
            ]);
            
            // SEND PERMANENT FAILURE EMAIL
            if ($recipientEmail) {
                try {
                    \Illuminate\Support\Facades\Mail::to($recipientEmail)->send(
                        new \App\Mail\ImportCompletedMail($importLog)
                    );
                } catch (\Exception $ex) {
                    Log::error('Failed to send Import Failed Email: ' . $ex->getMessage());
                }
            }
        }
    }
