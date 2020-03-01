<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;

class RegisterMember extends Mailable implements ShouldQueue
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
    public function build() {

        return $this->view('emails.register-member')
                ->subject(\Lang::get('emails.subject_send_mail_defaults', ['username' => $this->user->use_fullname ? $this->user->use_fullname : $this->user->use_username]))
                ->with([
                    'username' => $this->user->use_username,
                    'link' => $this->user->getActivateLink(),
                    'welcome_site_defaults' => 'Bạn đã đăng ký thành viên của <a href="' . env('APP_URL') . '" title="' . env('APP_URL') . '">' . env('APP_URL') . '</a> thành công<br/><br/>'
        ]);
    }

}
