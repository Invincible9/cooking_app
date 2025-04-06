<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        $adminUser = new User();
        $adminUser->setEmail('admin@admin.com');
        $adminUser->setUsername('admin');
        $adminUser->setPassword(
            $this->passwordHasher->hashPassword($adminUser, 'admin')
        );
        $adminUser->setRoles(['ROLE_ADMIN']);

        $user = new User();
        $user->setEmail('user@user.com');
        $user->setUsername('user');
        $user->setPassword(
            $this->passwordHasher->hashPassword($user, 'user')
        );
        $user->setRoles(['ROLE_USER']);

        $manager->persist($adminUser);
        $manager->persist($user);
        $manager->flush();
    }
}
