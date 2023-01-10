<?php

namespace App\DataFixtures;

use App\Entity\Mentorship;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class MentorshipFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($m = 10; $m < 40; $m++) {
            $mentorship = new Mentorship();
            $mentorship->setMentor($this->getReference('mentor_' . rand(0, 9)));
            $mentorship->setStudent($this->getReference('student_' . $m));
            $mentorship->setProject($this->getReference('project_' . rand(0, 9)));
            $mentorship->setStartDate($faker->dateTimeBetween('-2 months', '+1 months'));
            $mentorship->setEndDate($faker->dateTimeBetween('+1 months', '+2 months'));

            $manager->persist($mentorship);

            $this->addReference('mentorship_' . $m, $mentorship);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array(
            StudentFixtures::class,
            MentorFixtures::class,
            ProjectFixtures::class,
        );
    }
}
