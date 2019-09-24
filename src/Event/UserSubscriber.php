<?php
/**
 * Created by PhpStorm.
 * User: konra
 * Date: 23.09.2019 22:31
 */

namespace App\Event;

use App\Mailer\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class UserSubscriber implements EventSubscriberInterface
{
    /**
     * @var Mailer
     */
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            UserRegisterEvent::class => 'onUserRegister'
        ];
    }

    public function onUserRegister(UserRegisterEvent $event): void
    {
        $this->mailer->sendConfirmationEmail($event->getRegisteredUsed());
    }

}