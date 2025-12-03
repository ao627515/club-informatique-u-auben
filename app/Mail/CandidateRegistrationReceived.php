<?php

namespace App\Mail;

use App\Models\Candidate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CandidateRegistrationReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Candidate $candidate,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmation de réception de votre candidature',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.candidate.registration_received',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
