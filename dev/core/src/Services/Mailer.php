<?php namespace Engen\Services;

use Enstart\View\ViewInterface;
use Engen\Services\MailInterface;

class Mailer
{
    protected $views;

    public function __construct(ViewInterface $views, MailInterface $mail)
    {
        $this->views = $views;
        $this->mail  = $mail;
    }

    public function sendPasswordReset($id, $email)
    {
        $body = $this->views->render('admin::emails/reset-token', [
            'token' => $token
        ]);

        $subject = 'Engen: Reset password';

        return $this->mail->send($email, $subject, $body);
    }
}
