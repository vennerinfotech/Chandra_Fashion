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
        if ($importLog) {
            $importLog->update([
                'status' => 'processing',
                'started_at' => now(),
            ]);
        }

        // Update cache status
        Cache::put($this->sessionKey, [
            'total' => $this->totalRows,
            'current' => 0,
            'percentage' => 0,
            'status' => 'processing'
        ], now()->addHours(24));

        try {
            // Increase memory limit for large imports
            ini_set('memory_limit', '1024M');

            // Create import instance with progress tracking
            $importWithProgress = new ProductsImport($this->totalRows, $this->sessionKey);

            // Perform the import
            Excel::import($importWithProgress, $this->filePath);

            // Mark as completed
            Cache::put($this->sessionKey, [
                'total' => $this->totalRows,
                'current' => $this->totalRows,
                'percentage' => 100,
                'status' => 'completed'
            ], now()->addHours(24));

            if ($importLog) {
                $importLog->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                    'processed_rows' => $this->totalRows,
                    'successful_rows' => $this->totalRows,  // Adjust if you track failed rows separately
                ]);
            }

            Log::info('=== ImportProductsJob Completed Successfully ===');
        } catch (\Exception $e) {
            Log::error('=== ImportProductsJob Failed ===');
            Log::error('Error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            // Update cache with error status
            Cache::put($this->sessionKey, [
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
        if ($importLog) {
            $importLog->update([
                'status' => 'failed',
                'completed_at' => now(),
                'error_message' => 'Job failed after ' . $this->tries . ' attempts: ' . $exception->getMessage(),
            ]);
        }
    }
}
