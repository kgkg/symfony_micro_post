<?php
/**
 * Created by PhpStorm.
 * User: konra
 * Date: 27.09.2019 21:42
 */

namespace App\Tests\Mailer;

use App\Entity\User;
use App\Mailer\Mailer;
use PHPUnit\Framework\TestCase;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;

final class MailerTest extends TestCase
{
    public function test_should_send_confirmation_email(): void
    {
        // given
        $mailFrom = 'me@domain.com';
        $mailTo = 'john@doe.com';

        $user = new User();
        $user->setEmail($mailTo);

        $swiftMailer = $this->getMockBuilder(Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $swiftMailer->expects($this->once())->method('send')
            ->with($this->callback(
                function (Swift_Message $subject) use ($mailFrom, $mailTo): bool {
                    $messageStr = (string)$subject;

                    return (
                        strpos($messageStr, "From: {$mailFrom}") !== false
                        && strpos($messageStr, "To: {$mailTo}") !== false
                        && strpos($messageStr, "Content-Type: text/html; charset=utf-8") !== false
                        && strpos($messageStr, "Subject: Welcome to the micro-post app!") !== false
                        && strpos($messageStr, "This is a message body") !== false
                    );
                })
            );

        $twig = $this->getMockBuilder(Environment::class)
            ->disableOriginalConstructor()
            ->getMock();
        $twig->expects($this->once())->method('render')
            ->with('email/registration.html.twig', [
                'user' => $user,
            ])
            ->willReturn('This is a message body');

        /** @var Swift_Mailer $swiftMailer */
        /** @var Environment $twig */

        // when
        $mailer = new Mailer($swiftMailer, $twig, $mailFrom);
        $mailer->sendConfirmationEmail($user);
        // then

    }
}
