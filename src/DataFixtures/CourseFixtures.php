<?php

namespace App\DataFixtures;

use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
class CourseFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($c = 0; $c < 40; $c++) {
            $faker = Faker\Factory::create('fr_FR');
            $course = new Course();
            $course->setTitle($faker->sentence(6, true));
            $course->setContent($faker->paragraph(10, true));
            $course->setCategory($this->getReference('category_' . rand(1, 5)));
            $course->setLevel($this->getReference('level_' . rand(1, 4)));

            $manager->persist($course);

            // create reference for later use
            $this->addReference('course_' . $c, $course);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array(
            CategoryFixtures::class,
            LevelFixtures::class,
        );
    }
}
