<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/home', name: 'home')]
    public function homePageAdmin() 
    {
        return $this->render('home/homepageadmin.html.twig');
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/home', name: 'home')]
    public function homePage() 
    {
        return $this->render('home/homepage.html.twig');
    }
}
