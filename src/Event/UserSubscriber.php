<?php
/**
 * Created by PhpStorm.
 * User: konra
 * Date: 23.09.2019 22:31
 */

namespace App\Event;

use App\Entity\UserPreferences;
use App\Mailer\Mailer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class UserSubscriber implements EventSubscriberInterface
{
    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var string
     */
    private $defaultLocale;

    public function __construct(Mailer $mailer, EntityManagerInterface $entityManager, string $defaultLocale)
    {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
        $this->defaultLocale = $defaultLocale;
    }

    public static function getSubscribedEvents()
    {
        return [
            UserRegisterEvent::class => 'onUserRegister'
        ];
    }

    public function onUserRegister(UserRegisterEvent $event): void
    {
        $this->setDefaultUserPreferences($event);
        $this->sendConfirmationEmail($event);
    }

    private function sendConfirmationEmail(UserRegisterEvent $event): void
    {
        $this->mailer->sendConfirmationEmail($event->getRegisteredUsed());
    }

    private function setDefaultUserPreferences(UserRegisterEvent $event): void
    {
        $preferences = new UserPreferences();
        $preferences->setLocale($this->defaultLocale);

        $user = $event->getRegisteredUsed();
        $user->setPreferences($preferences);

        $this->entityManager->flush();
    }

}