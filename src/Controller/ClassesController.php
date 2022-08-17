<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Repository\ClassesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/classes')]
class ClassesController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/index', name: 'classes_index')]
    public function ClassesIndex()
    {
        $classes = $this -> getDoctrine() -> getRepository(Classes::class) -> findAll();
        return $this->render('classes/index.html.twig',
        [
            'classes' => $classes
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/detail/{id}', name: 'classes_detail_admin')]
    public function ClassesDetailAdmin ($id, ClassesRepository $classesRepository) {
    $classes = $classesRepository->find($id);
    if ($classes == null) 
    {
        $this->addFlash('Warning', 'Invalid class id !');
        return $this->redirectToRoute('classes_index');
    }
    return $this->render('classes/detail.html.twig',
        [
            'classes' => $classes
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/detail/{id}', name: 'classes_detail')]
    public function ClassesDetail ($id, ClassesRepository $classesRepository) {
    $classes = $classesRepository->find($id);
    if ($classes == null) 
    {
        $this->addFlash('Warning', 'Invalid class id !');
        return $this->redirectToRoute('classes_index');
    }
    return $this->render('classes/detail.html.twig',
        [
            'classes' => $classes
        ]);
    }
}
