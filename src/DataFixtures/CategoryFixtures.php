<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setCatId('Ca1');
        $category->setName('Keyboard');
        $manager->persist($category);
        $category = new Category();
        $category->setCatId('Ca2');
        $category->setName('Mouse');
        $manager->persist($category);
        $manager->flush();
        $manager->flush();

        $manager->flush();
    }
}
