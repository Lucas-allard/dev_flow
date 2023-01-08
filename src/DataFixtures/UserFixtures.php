<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($u = 0; $u < 40; $u++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword($faker->password);
            $user->setRoles(['ROLE_USER']);
            $user->setFullName($faker->name);
            $user->setCreatedAt($faker->dateTimeBetween('-6 months'));
            $user->setGoogleId($faker->uuid);
            for ($c = 0; $c < rand(1, 5); $c++) {
                $user->addCourse($this->getReference('course_' . rand(0, 39)));
            }
            // create reference for later use
            $this->addReference('user_' . $u, $user);
        }
    }

    public function getDependencies(): array
    {
        return array(
            CourseFixtures::class,
        );
    }
}

