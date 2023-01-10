<?php

namespace App\DataFixtures;

use App\Entity\Mentor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MentorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($m = 0; $m < 10; $m++) {
            $mentor = new Mentor();
            $mentor->setUser($this->getReference('user_' . $m));

            // create reference for later use

            $manager->persist($mentor);

            $this->addReference('mentor_' . $m, $mentor);
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
