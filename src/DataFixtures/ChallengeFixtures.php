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
            $challenge->setCreatedAt($faker->dateTimeBetween('-3 months', '-3 months'));
            $challenge->setName($faker->sentence(6, true));
            $description = "<div>
                <p>" . $faker->paragraph(10, true) . "</p><img src='" . $faker->imageUrl(640, 480) . "' alt='Challenge image'>
                    <p>" . $faker->paragraph(7, true) . "</p>
                    <img src='" . $faker->imageUrl(640, 480) . "' alt='Challenge image'><p>" . $faker->paragraph(5, true) . "</p></div>";
            $challenge->setDescription($description);
            $challenge->setCategory($this->getReference('category_' . rand(1, 6)));
            $challenge->setLevel($this->getReference('level_' . rand(1, 4)));
            $challenge->setStartDate($faker->dateTimeBetween('-3 months', 'now'));
            $challenge->setEndDate($faker->dateTimeBetween('-1 months', '2 months'));
            $challenge->setPoints(rand(10, 100));
            $challenge->setTrophy($this->getReference('trophy_' . rand(10, 14)));

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
