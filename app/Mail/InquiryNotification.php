<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;

    public function __construct(Inquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    public function build()
    {
        return $this->subject('New Villa Inquiry - ' . ($this->inquiry->villa?->name ?? 'General Inquiry'))
                    ->markdown('emails.inquiry.notification')
                    ->replyTo($this->inquiry->email, $this->inquiry->name);
    }
}
