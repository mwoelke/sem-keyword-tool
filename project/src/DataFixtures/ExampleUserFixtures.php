<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ExampleUserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail('user@user.de');
        $user1->setPassword(
            $this->userPasswordHasher->hashPassword($user1, 'sh7up#KT!')
        );
        $user1->setRoles(['ROLE_USER']);
        $manager->persist($user1);

        $manager->flush();
    }
}
