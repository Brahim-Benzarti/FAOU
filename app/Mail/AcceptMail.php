<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Email;

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
    public $body;
    public $footer;

    
    public function __construct($Applicant_Name,$User_Name,$User_Phone,$User_Position)
    {
        $content=Email::where('name','accept')->first();
        $this->body=$content->main;
        $this->footer=$content->secondary;
        $this->Applicant_Name=$Applicant_Name;
        $this->User_Name=$User_Name;
        $this->User_Position=$User_Position;
        $this->User_Phone=$User_Phone;
        $this->hasfiles=0;
        if($content->files){
            $this->hasfiles=1;
            $this->files=explode('|',$content->files);
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail= $this->markdown('emails.accept')->subject("FAOU Autumn 2021 Hiring Process - Accepted!");
        if($this->hasfiles){
            foreach($this->files as $file){
                $mail->attach(public_path('/files/email/accept/'.$file));
            }
        }
        return $mail;
    }
}
