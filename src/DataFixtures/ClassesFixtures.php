<?php

namespace App\DataFixtures;

use App\Entity\Classes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClassesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        for ($i = 1; $i <= 15; $i++) {
            $key = substr(str_shuffle($str_result), 0, 2);
            $classes = new Classes;
            $classes->setName("G" . $key . "10$i")
                    ->setInfo("Total students:" . rand(25,30));
            $manager->persist($classes);
        }
        $manager->flush();
    }
}
