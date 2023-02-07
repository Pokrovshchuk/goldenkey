<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Callback extends Mailable
{
    use Queueable, SerializesModels;

    public string $email;
    public $name, $phone, $text;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $name = null, $phone = null, $text = null)
    {
        $this->email = $email;
        $this->name = $name;
        $this->phone = $phone;
        $this->text = $text;
    }

    /**
     * Build the message.
     *
     * @return Callback
     */
    public function build()
    {
        return $this->from('info@goldenkey.world')->view('mail.callback',
            [
                'email' => $this->email,
                'name' => $this->name,
                'phone' => $this->phone,
                'text' => $this->text,
            ]);
    }
}
