<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Course;
use App\Entity\Author;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();

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

        for ($u = 0; $u < 30; $u++) {
            $user = new User();
            $password = $this->hasher->hashPassword($user, '0000');

            $user->setFullName($faker->name())
                ->setCreatedAt($faker->dateTimeBetween("-7 months", "now"))
                ->setEmail($faker->email())
                ->setPassword($password)
                ->setIsLogged(false);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
