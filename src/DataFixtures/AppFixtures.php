<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Course;
use App\Entity\Author;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($u = 0; $u < 2; $u++) {
            $author = new Author();
            $author->setFirstName("Lucas")
                ->setLastName("Allard")
                ->setProfilDescription("Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem dolores error perferendis porro totam!")
                ->setProfilPicture("profil picture");
            $manager->persist($author);

            for ($i = 0; $i < 3; $i++) {
                $category = new Category();
                $category->setName("catégorie " . $i)
                    ->setSlug("catégorie " . $i)
                    ->setDescription("Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem dolores error perferendis porro totam!");
                $manager->persist($category);

                for ($c = 0; $c < 4; $c++) {
                    $course = new Course();
                    $course->setCategory($category)
                        ->setTitle("cours " . $c)
                        ->setContent("Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem dolores error perferendis porro totam!")
                        ->setSlug("cours " . $c)
                        ->setCreatedAt(new DateTime())
                        ->setAuthor($author);
                    $manager->persist($course);

                }
            }
        }
        $manager->flush();
    }
}
