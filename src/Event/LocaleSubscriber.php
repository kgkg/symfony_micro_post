<?php
/**
 * Created by PhpStorm.
 * User: konra
 * Date: 26.09.2019 21:58
 */

namespace App\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class LocaleSubscriber implements EventSubscriberInterface
{
    /**
     * @var string
     */
    private $defaultLocale;

    public function __construct($defaultLocale = 'en')
    {
        $this->defaultLocale = $defaultLocale;
    }

    public static function getSubscribedEvents()
    {
        return [
            RequestEvent::class => [
                [
                    'onKernelRequest',
                    20
                ]
            ]
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ($request->hasPreviousSession() === false) {
            return;
        }

        $locale = $request->attributes->get('_locale');
        if ($locale) {
            $request->getSession()->set('_locale', $locale);
        }
        else {
            $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
        }
    }
}