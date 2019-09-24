<?php
/**
 * Created by PhpStorm.
 * User: konra
 * Date: 23.09.2019 22:22
 */

namespace App\Event;


use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

final class UserRegisterEvent extends Event
{
    const NAME = 'user.register';

    /**
     * @var User
     */
    private $registeredUsed;

    public function __construct(User $registeredUsed)
    {
        $this->registeredUsed = $registeredUsed;
    }

    public function getRegisteredUsed(): User
    {
        return $this->registeredUsed;
    }

}