<?php
/**
 * Created by PhpStorm.
 * User: konra
 * Date: 24.09.2019 15:48
 */

namespace App\Mailer;

use App\Entity\User;
use Twig\Environment;

final class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var string
     */
    private $mailFrom;

    public function __construct(\Swift_Mailer $mailer, Environment $twig, string $mailFrom)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->mailFrom = $mailFrom;
    }

    public function sendConfirmationEmail(User $user): void
    {
        $body = $this->twig->render('email/registration.html.twig', [
            'user' => $user,
        ]);

        $message = (new \Swift_Message())
            ->setCharset('utf-8')
            ->setFrom($this->mailFrom)
            ->setTo($user->getEmail())
            ->setSubject('Welcome to the micro-post app!')
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }
}