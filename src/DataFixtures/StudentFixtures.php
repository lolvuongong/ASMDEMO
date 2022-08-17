<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i < 20; $i++) {
            $student = new Student;
            $student->setName("Student $i")
                ->setPhone(0 . rand(100000000, 999999999))
                ->setEmail("student$i@fpt.edu.vn")
                ->setImage("https://static2.yan.vn/YanNews/2167221/202102/facebook-cap-nhat-avatar-doi-voi-tai-khoan-khong-su-dung-anh-dai-dien-e4abd14d.jpg");
            $manager->persist($student);
        }
        $manager->flush();
    }
}
