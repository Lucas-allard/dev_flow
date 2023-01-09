<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ProjectFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($p = 0; $p < 10; $p++) {
            $project = new Project();
            $project->setMentor($this->getReference('mentor_' . $p));
            $project->setTitle($faker->sentence(6, true));
            $project->setDeadline($faker->dateTimeBetween('-2 months', '+2 months'));
            $project->setDescription($faker->paragraphs(10, true));

            $manager->persist($project);

            // create reference for later use
            $this->addReference('project_' . $p, $project);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array(
            MentorFixtures::class,
        );
    }
}
