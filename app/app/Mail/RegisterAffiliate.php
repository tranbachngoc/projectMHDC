<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;

class RegisterAffiliate extends Mailable implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var Order
     */
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user = null)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.register-affiliate')
                    ->subject(\Lang::get('emails.subject_send_mail_defaults', [ 'username' => $this->user->use_fullname ?  $this->user->use_fullname : $this->user->use_username]))
                    ->with([
                        'username' => $this->user->use_username
                    ]);
    }
}
