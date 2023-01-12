<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {


        $category = new Category();
        $category->setName('HTML')
            ->setDescription('Tous les cours de la catégorie HTML')
            ->setColor("#E74E26");

        $manager->persist($category);
        // add reference for later use
        $this->addReference('category_1', $category);

        $category = new Category();

        $category->setName('CSS')
            ->setDescription('Tous les cours de la catégorie CSS')
            ->setColor("#264DE3");

        $manager->persist($category);
        // add reference for later use
        $this->addReference('category_2', $category);

        $category = new Category();

        $category->setName('JavaScript')
            ->setDescription('Tous les cours de la catégorie JavaScript')
            ->setColor("#E2C430");

        $manager->persist($category);

        $this->addReference('category_3', $category);

        $category = new Category();

        $category->setName('PHP')
            ->setDescription('Tous les cours de la catégorie PHP')
            ->setColor("#858EB8");

        $manager->persist($category);

        $this->addReference('category_4', $category);

        $category = new Category();

        $category->setName('Symfony')
            ->setDescription('Tous les cours de la catégorie Symfony')
            ->setColor("#F7F7F7");

        $manager->persist($category);

        $this->addReference('category_5', $category);

        $category = new Category();

        $category->setName('React')
            ->setDescription('Tous les cours de la catégorie React')
            ->setColor("#00D1F7");

        $manager->persist($category);

        $this->addReference('category_6', $category);
        $manager->flush();
    }
}
