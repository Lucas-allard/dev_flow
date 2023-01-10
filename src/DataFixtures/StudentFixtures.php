<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StudentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
       for ($s = 10; $s < 40; $s++) {
            $student = new Student();
            $student->setUser($this->getReference('user_' . $s));

            $manager->persist($student);

            // create reference for later use
            $this->addReference('student_' . $s, $student);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array(
            UserFixtures::class,
        );
    }
}
