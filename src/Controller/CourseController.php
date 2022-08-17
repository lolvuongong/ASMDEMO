<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/course')]
class CourseController extends AbstractController
{
    #[Route('/index', name: 'course_index')]
    public function CourseIndex()
    {
        $courses = $this -> getDoctrine() -> getRepository(Course::class) -> findAll();
        return $this->render('course/index.html.twig',
        [
            'courses' => $courses
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/detail/{id}', name: 'course_detail_admin')]
    public function CourseDetailAdmin($id, CourseRepository $courseRepository)
    {
        $course = $courseRepository->find($id);
        if ($course == null) {
            $this->addFlash('Warning', 'Invalid course id !');
            return $this->redirectToRoute('course_index');
        }
        return $this->render(
            'course/detail.html.twig',
            [
                'course' => $course
            ]
        );
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/detail/{id}', name: 'course_detail')]
    public function CourseDetail($id, CourseRepository $courseRepository)
    {
        $course = $courseRepository->find($id);
        if ($course == null) {
            $this->addFlash('Warning', 'Invalid course id !');
            return $this->redirectToRoute('home');
        }
        return $this->render(
            'course/detail.html.twig',
            [
                'course' => $course
            ]
        );
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/delete/{id}', name: 'course_delete')]
    public function courseDelete ($id, ManagerRegistry $managerRegistry) 
    {
        $course = $managerRegistry->getRepository(course::class)->find($id);
        if ($course == null) 
        {
            $this->addFlash('Warning', 'course not existed !');
        } 
        else 
        {
            $manager = $managerRegistry->getManager();
            $manager->remove($course);
            $manager->flush();
            $this->addFlash('Info', 'Delete course successfully !');
        }
        return $this->redirectToRoute('course_index');
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/add', name: 'course_add')]
    public function courseAdd (Request $request) 
    {
        $course = new Course;
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($course);
            $manager->flush();
            $this->addFlash('Info','Add course successfully !');
            return $this->redirectToRoute('course_index');
        }
        return $this->renderForm('course/add.html.twig',
        [
            'courseForm' => $form
        ]);
    }

    #[Route('/edit/{id}', name: 'course_edit')]
    public function courseEdit ($id, Request $request) 
    {
        $course = $this->getDoctrine()->getRepository(Course::class)->find($id);
        if ($course == null) 
        {
            $this->addFlash('Warning', 'course not existed !');
            return $this->redirectToRoute('course_index');
        } 
        else 
        {   
            $form = $this->createForm(CourseType::class, $course);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) 
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($course);
                $manager->flush();
                $this->addFlash('Info','Add course successfully !');
                return $this->redirectToRoute('course_index');
            }
        }        
        return $this->renderForm('course/edit.html.twig',
        [
            'courseForm' => $form
        ]);
    }
}
