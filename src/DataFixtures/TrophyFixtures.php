<?php

namespace App\DataFixtures;

use App\Entity\Trophy;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
class TrophyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($t = 0; $t < 10; $t++) {
            $trophy = new Trophy();
            $trophy->setName('Trophy ' . $t);
            $trophy->setDescription('Description of trophy ' . $t);
            $trophy->setDate($faker->dateTimeBetween('-6 months'));
            $trophy->setRequiredPoint($faker->numberBetween(1, 1000));
            $manager->persist($trophy);

            // create reference for later use
            $this->addReference('trophy_' . $t, $trophy);

        }

        for ($t = 10; $t < 15; $t++) {
            $trophy = new Trophy();
            $trophy->setName('Trophy ' . $t);
            $trophy->setDescription('Description of trophy ' . $t);
            $trophy->setDate($faker->dateTimeBetween('-6 months'));
            $manager->persist($trophy);

            // create reference for later use
            $this->addReference('trophy_' . $t, $trophy);

        }


        $manager->flush();
    }
}
