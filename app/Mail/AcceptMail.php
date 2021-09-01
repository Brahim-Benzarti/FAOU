<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AcceptMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $Applicant_Name;
    public $User_Name;
    public $User_Position;
    public $User_Phone;

    
    public function __construct($Applicant_Name,$User_Name,$User_Phone,$User_Position)
    {
        $this->Applicant_Name=$Applicant_Name;
        $this->User_Name=$User_Name;
        $this->User_Position=$User_Position;
        $this->User_Phone=$User_Phone;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.accept');
    }
}
