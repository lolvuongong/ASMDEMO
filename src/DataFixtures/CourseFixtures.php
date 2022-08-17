<?php

namespace App\DataFixtures;

use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $names = ["Web", "Prog", "VOG"];

        for ($i = 1; $i <= 15; $i++) {
            $key = array_rand($names, 1);
            $course = new Course;
            $course->setName("Course $i")
                ->setInfo($names[$key] . rand(100, 300))
                ->setAttendance((bool) rand(0, 1))
                ->setGrade((float) rand(0, 10));
            $manager->persist($course);
        }
        $manager->flush();
    }
}
