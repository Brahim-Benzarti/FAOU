<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InterviewMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $Applicant_Name;
    public $Meeting_Link;
    public $User_Name;
    public $User_Position;
    public $User_Phone;

    
    public function __construct($Applicant_Name,$Meeting_Link,$User_Name,$User_Phone,$User_Position)
    {
        $this->Applicant_Name=$Applicant_Name;
        $this->Meeting_Link=$Meeting_Link;
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
        return $this->markdown('emails.interview')->subject("FAOU Autumn 2021 Hiring Process - Interviews");
    }
}