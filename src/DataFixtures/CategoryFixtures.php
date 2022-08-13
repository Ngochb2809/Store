<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setName('Keyboard');
        $manager->persist($category);
        $category = new Category();
        $category->setName('Mouse');
        $manager->persist($category);
        $manager->flush();
        $manager->flush();

        $manager->flush();
    }
}
