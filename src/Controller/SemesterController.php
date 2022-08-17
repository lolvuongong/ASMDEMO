<?php

namespace App\Controller;

use App\Entity\Semester;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SemesterController extends AbstractController
{
    #[Route('/semester/index', name: 'semester_index')]
    public function semesterIndex()
    {
        $semesters = $this -> getDoctrine() -> getRepository(Semester::class) -> findAll();
        return $this->render('semester/index.html.twig',
        [
            'semesters' => $semesters
        ]);
    }
}
