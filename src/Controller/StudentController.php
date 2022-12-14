<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/student')]
class StudentController extends AbstractController
{
    #[Route('/index', name:'student_index')]
function StudentIndex()
    {
    $students = $this->getDoctrine()->getRepository(Student::class)->findAll();
    return $this->render('student/index.html.twig',
        [
            'students' => $students,
        ]);
}

#[Route('/detail/{id}', name:'student_detail')]
function StudentDetailAdmin($id, StudentRepository $studentRepository)
    {
    $student = $studentRepository->find($id);
    if ($student == null) {
        $this->addFlash('Warning', 'Invalid student id !');
        return $this->redirectToRoute('home');
    }
    return $this->render('student/detail.html.twig',
        [
            'student' => $student,
        ]);
}

#[IsGranted('ROLE_ADMIN')]
#[Route('/delete/{id}', name:'student_delete')]
function StudentDelete($id, ManagerRegistry $managerRegistry)
    {
    $student = $managerRegistry->getRepository(Student::class)->find($id);
    if ($student == null) {
        $this->addFlash('Warning', 'Student not existed !');
    } else {
        $manager = $managerRegistry->getManager();
        $manager->remove($student);
        $manager->flush();
        $this->addFlash('Info', 'Delete student successfully !');
    }
    return $this->redirectToRoute('student_index');
}

#[IsGranted('ROLE_ADMIN')]
#[Route('/add', name:'student_add')]
function StudentAdd(Request $request)
    {
    $student = new Student;
    $form = $this->createForm(StudentType::class, $student);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($student);
        $manager->flush();
        $this->addFlash('Info', 'Add student successfully !');
        return $this->redirectToRoute('student_index');
    }
    return $this->renderForm('student/add.html.twig',
        [
            'studentForm' => $form,
        ]);
}

#[IsGranted('ROLE_ADMIN')]
#[Route('/edit/{id}', name:'student_edit')]
function studentEdit($id, Request $request)
    {
    $student = $this->getDoctrine()->getRepository(Student::class)->find($id);
    if ($student == null) {
        $this->addFlash('Warning', 'Student not existed !');
        return $this->redirectToRoute('student_index');
    } else {
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($student);
            $manager->flush();
            $this->addFlash('Info', 'Add student successfully !');
            return $this->redirectToRoute('student_index');
        }
    }
    return $this->renderForm('student/edit.html.twig',
        [
            'studentForm' => $form,
        ]);
}


#[Route('/search', name: 'search_student')]
function searchStudent(StudentRepository $studentRepository, Request $request)
    {
    $students = $studentRepository->searchBook($request->get('keyword'));
    $session = $request->getSession();
    $session->set('search', true);
    return $this->render('student/index.html.twig', [
        'students' => $students,
    ]);
}

}
