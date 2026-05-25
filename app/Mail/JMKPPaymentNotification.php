<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JMKPPaymentNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $user;
    public $course;
    public $payment;
    public function __construct($user, $course, $payment)
    {
        $this->user = $user;
        $this->course = $course;
        $this->payment = $payment;
    }
    public function build()
    {
        return $this->subject('Pembayaran JMKP Berhasil')
            ->view('emails.jmkp_payment');
    }
}
