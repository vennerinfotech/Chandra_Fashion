<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ImportStartedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $fileName;
    public $totalRows;
    public $startTime;

    /**
     * Create a new message instance.
     */
    public function __construct($fileName, $totalRows, $startTime)
    {
        $this->fileName = $fileName;
        $this->totalRows = $totalRows;
        $this->startTime = $startTime;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Hashtag: Product Import Started - ' . $this->fileName,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.import.started',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
