<?php
/**
 * Created by PhpStorm.
 * User: konra
 * Date: 24.09.2019 21:26
 */

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserChecker implements UserCheckerInterface
{

    public function checkPreAuth(UserInterface $user)
    {
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }

        if ($user->isEnabled() === false) {
            throw new DisabledException('You need to first activate your account using the link from your registration e-mail.');
        }
    }
}