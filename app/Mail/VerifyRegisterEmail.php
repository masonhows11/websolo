<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class VerifyRegisterEmail extends Mailable
{
    use Queueable, SerializesModels;


    // step six get user new register info in VerifyRegisterEmail when instance created
    protected $user;
    protected $encrypted;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param $encrypted
     */
    public function __construct(User $user,$encrypted)
    {
        $this->user = $user;
        $this->encrypted = $encrypted;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // send info user to view email for send to new user
        return $this->markdown('emails.verify_email')
            ->subject('webkade.test')
            ->with([
                'user'=>$this->user,
                'id'=>$this->user->id,
                'encrypted' => $this->encrypted]);
    }
}
