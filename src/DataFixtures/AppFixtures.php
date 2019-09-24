<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private const USERS = [
        [
            'username' => 'john_doe',
            'email' => 'john_doe@doe.com',
            'password' => 'john123',
            'fullName' => 'John Doe',
            'roles' => [User::ROLE_USER],
        ],
        [
            'username' => 'rob_smith',
            'email' => 'rob_smith@smith.com',
            'password' => 'rob12345',
            'fullName' => 'Rob Smith',
            'roles' => [User::ROLE_USER],
        ],
        [
            'username' => 'marry_gold',
            'email' => 'marry_gold@gold.com',
            'password' => 'marry12345',
            'fullName' => 'Marry Gold',
            'roles' => [User::ROLE_USER],
        ],
        [
            'username' => 'admin',
            'email' => 'admind@admin.com',
            'password' => 'admin12345',
            'fullName' => 'Micro Admin',
            'roles' => [User::ROLE_ADMIN],
        ],
    ];

    private const POST_TEXT = [
        'Hello, how are you?',
        'It\'s nice sunny weather today',
        'I need to buy some ice cream!',
        'I wanna buy a new car',
        'There\'s a problem with my phone',
        'I need to go to the doctor',
        'What are you up to today?',
        'Did you watch the game yesterday?',
        'How was your day?'
    ];

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadMicroPosts($manager);
    }

    private function loadUsers(ObjectManager $manager): void
    {
        foreach (self::USERS as $userData) {
            $user = new User();
            $user->setUsername($userData['username']);
            $user->setFullName($userData['fullName']);
            $user->setEmail($userData['email']);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                $userData['password'])
            );
            $user->setRoles($userData['roles']);
            $user->setEnabled(true);

            $this->addReference($userData['username'], $user);

            $manager->persist($user);
        }

        $manager->flush();
    }

    private function loadMicroPosts(ObjectManager $manager): void
    {
        for ($i = 0; $i < 30; $i++) {
            $microPost = new MicroPost();
            $microPost->setText(self::POST_TEXT[array_rand(self::POST_TEXT)]);
            $date = new \DateTime();
            $date->modify('-' . rand(0, 10) . ' day');
            $microPost->setTime($date);
            $microPost->setUser($this->getReference(self::USERS[array_rand(self::USERS)]['username']));
            $manager->persist($microPost);
        }

        $manager->flush();
    }

}
