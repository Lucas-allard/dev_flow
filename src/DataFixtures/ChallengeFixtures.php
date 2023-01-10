<?php

namespace App\DataFixtures;

use App\Entity\Challenge;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ChallengeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($c = 0; $c < 20; $c++) {
            $challenge = new Challenge();
            $challenge->setName($faker->sentence(6, true));
            $challenge->setDescription($faker->paragraph(10, true));
            $challenge->setStartDate($faker->dateTimeBetween('-2 months', '-1 months'));
            $challenge->setEndDate($faker->dateTimeBetween('2 months', '4 months'));
            $challenge->setTrophy($this->getReference('trophy_' . rand(10, 14)));
            for ($i = 0; $i < rand(1, 39); $i++) {
                $challenge->addUser($this->getReference('user_' . $i));
            }
            $manager->persist($challenge);

            // create reference for later use
            $this->addReference('challenge_' . $c, $challenge);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array(
            UserFixtures::class,
            TrophyFixtures::class,
        );
    }
}
