<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserCourse;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    //constuctor with password hasher

    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($u = 0; $u < 40; $u++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword($this->passwordEncoder->hashPassword($user, 'password'));
            $user->setRoles(['ROLE_USER']);
            $user->setFullName($faker->name);
            $user->setCreatedAt($faker->dateTimeBetween('-6 months'));
            $user->setGoogleId($faker->uuid);
            $user->setPoints($faker->numberBetween(1, 1000));


            if ($user->getPoints() <= 99) {
                $user->setLevel($this->getReference('level_1'));
            } elseif ($user->getPoints() <= 249) {
                $user->setLevel($this->getReference('level_2'));
            } elseif ($user->getPoints() <= 499) {
                $user->setLevel($this->getReference('level_3'));
            } else {
                $user->setLevel($this->getReference('level_4'));
            }


            if ($user->getPoints() >= $this->getReference('trophy_10')->getRequiredPoint()) {
                $user->addTrophy($this->getReference('trophy_10'));
            }
            if ($user->getPoints() >= $this->getReference('trophy_11')->getRequiredPoint()) {
                $user->addTrophy($this->getReference('trophy_1'));
            }
            if ($user->getPoints() >= $this->getReference('trophy_12')->getRequiredPoint()) {
                $user->addTrophy($this->getReference('trophy_12'));
            }
            if ($user->getPoints() >= $this->getReference('trophy_13')->getRequiredPoint()) {
                $user->addTrophy($this->getReference('trophy_13'));
            }

            if ($user->getPoints() >= $this->getReference('trophy_14')->getRequiredPoint()) {
                $user->addTrophy($this->getReference('trophy_14'));
            }


            $manager->persist($user);
            // create reference for later use
            $this->addReference('user_' . $u, $user);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array(
            CourseFixtures::class,
            TrophyFixtures::class,
        );
    }
}

