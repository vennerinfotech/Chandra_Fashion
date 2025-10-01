<?php

namespace App\Jobs;

use App\Mail\InquiryUserMail;
use App\Mail\InquiryAdminMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
class SendInquiryEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->data['user_email'])
                ->later(now()->addSeconds(1), new InquiryUserMail($this->data));

            Mail::to(env('ADMIN_EMAIL'))
                ->later(now()->addSeconds(3), new InquiryAdminMail($this->data));
        } catch (\Exception $e) {
            \Log::error('Email scheduling failed: '.$e->getMessage());
        }
    }


}
