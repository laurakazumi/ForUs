<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMe extends Mailable
{
    use Queueable, SerializesModels;

    public $dataReceived;

    /**
     * Create a new message instance.
     *
     * @param array $data
     * @return void
     */
    public function __construct($data)
    {
        $this->dataReceived = $data;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->dataReceived['name'],
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emailTamplate',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->view('emailTemplate')
            ->with('data', $this->dataReceived);

        // Adicionar o anexo, se existir
        if (!empty($this->data['comprovante'])) {
            $filePath = storage_path('app/' . $this->data['comprovante']);
            Log::info('Attachment path: ' . $filePath);
            if (file_exists($filePath)) {
                $email->attach($filePath);
            } else {
                Log::error('File does not exist: ' . $filePath);
            }
        }

        return $email;
    }
    // public function build()
    // {
    //     return $this->view('emailTamplate')
    //                 ->with('data', $this->dataReceived);
    // }
}
