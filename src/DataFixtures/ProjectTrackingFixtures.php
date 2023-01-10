<?php

namespace App\DataFixtures;

use App\Entity\ProjectTracking;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ProjectTrackingFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();

        for ($p = 10; $p < 40; $p++) {
            $projectTracking = new ProjectTracking();
            $projectTracking->setProject($this->getReference('project_' . rand(0, 9)));
            $projectTracking->setStudent($this->getReference('student_' . $p));
            $projectTracking->setCompletionDate($faker->dateTimeBetween('-1 months', '3 months'));
            $projectTracking->setCompletionStatus($faker->randomElement(['incomplete', 'complete']));

            $manager->persist($projectTracking);

            // create reference for later use
            $this->addReference('project_' . $p, $projectTracking);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array(
            UserFixtures::class,
            StudentFixtures::class,
            ProjectFixtures::class,
        );
    }
}
