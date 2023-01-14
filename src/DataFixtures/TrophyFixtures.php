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
            $trophy->setImg('images/rank_mid/rank_mid_' . $t + 1 . '.png');
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
            $trophy->setImg('images/rank_high/rank_high_' . $t + 1 . '.png');
            $trophy->setDescription('Description of trophy ' . $t);
            $trophy->setDate($faker->dateTimeBetween('-6 months'));
            $manager->persist($trophy);

            // create reference for later use
            $this->addReference('trophy_' . $t, $trophy);

        }

        for ($t = 15; $t < 20; $t++) {
            $trophy = new Trophy();
            $trophy->setName('Trophy ' . $t);
            $trophy->setImg('images/rank_low/rank_low_' . $t - 4 . '.png');
            $trophy->setDescription('Description of trophy ' . $t);
            $trophy->setDate($faker->dateTimeBetween('-6 months'));
            $trophy->setRequiredMessage($faker->numberBetween(1, 2000));
            $manager->persist($trophy);

            // create reference for later use
            $this->addReference('trophy_' . $t, $trophy);

        }

        $manager->flush();
    }
}
