<?php

declare(strict_types=1);

namespace App\Tests\Common\Fixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public const FIRST_USER = 'test1@test.com';
    public const SECOND_USER = 'test2@test.com';

    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public static function getGroups(): array
    {
        return ['test-data'];
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail(self::FIRST_USER);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, '123456789'));
        $manager->persist($user);
        $manager->flush();

        $user = new User();
        $user->setEmail(self::SECOND_USER);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, '123456789'));
        $manager->persist($user);
        $manager->flush();
    }
}
