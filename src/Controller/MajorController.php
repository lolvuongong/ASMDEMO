<?php

namespace App\Controller;

use App\Entity\Major;
use App\Repository\MajorRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/major')]
class MajorController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/index', name: 'major_index')]
    public function majorIndex()
    {
        $major = $this -> getDoctrine() -> getRepository(Major::class) -> findAll();
        return $this->render('major/index.html.twig',
        [
            'major' => $major
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/detail/{id}', name: 'major_detail_admin')]
    public function majorDetailAdmin ($id, MajorRepository $majorRepository) {
    $major = $majorRepository->find($id);
    if ($major == null) 
    {
        $this->addFlash('Warning', 'Invalid major id !');
        return $this->redirectToRoute('major_index');
    }
    return $this->render('major/detail.html.twig',
        [
            'major' => $major
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/detail/{id}', name: 'major_detail')]
    public function majorDetail ($id, MajorRepository $majorRepository) {
    $major = $majorRepository->find($id);
    if ($major == null) 
    {
        $this->addFlash('Warning', 'Invalid major id !');
        return $this->redirectToRoute('home');
    }
    return $this->render('major/detail.html.twig',
        [
            'major' => $major
        ]);
    }
}
