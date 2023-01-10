<?php

namespace App\DataFixtures;

use App\Entity\Level;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LevelFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $level = new Level();
        $level->setName('Débutant');
        $level->setDescription('Tous les cours de niveau débutant');
        $level->setRequiredPoint(0);
        $level->setColor('green');
        $manager->persist($level);

        $this->addReference('level_1', $level);

        $level = new Level();
        $level->setName('Intermédiaire');
        $level->setDescription('Tous les cours de niveau intermédiaire');
        $level->setRequiredPoint(100);
        $level->setColor('orange');
        $manager->persist($level);

        $this->addReference('level_2', $level);

        $level = new Level();
        $level->setName('Avancé');
        $level->setDescription('Tous les cours de niveau avancé');
        $level->setRequiredPoint(500);
        $level->setColor('red');
        $manager->persist($level);

        $this->addReference('level_3', $level);

        $level = new Level();
        $level->setName('Expert');
        $level->setRequiredPoint(1000);
        $level->setDescription('Tous les cours de niveau expert');
        $level->setColor('purple');
        $manager->persist($level);

        $this->addReference('level_4', $level);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array(
            CategoryFixtures::class,
        );
    }
}
