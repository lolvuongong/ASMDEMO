<?php

namespace App\DataFixtures;

use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubjectFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $names = ["Security", "Java", "C#", "C++", "Cloud Computing", "VOV", "Web design"];
        for ($i = 0; $i <= 6; $i++) {
            $subject = new Subject;
            $subject->setName($names[$i])
                    ->setInfo("Description of subject")
                    ->setFee((float)(rand(200, 300)));
            $manager->persist($subject);
        }
        $manager->flush();
    }
}
