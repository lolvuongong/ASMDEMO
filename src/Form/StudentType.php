<?php

namespace App\Form;

use App\Entity\Major;
use App\Entity\Course;
use App\Entity\Classes;
use App\Entity\Student;
use App\Entity\Semester;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class,
        [
            'label' => 'Student Name',
            'attr' => [
                'minlength' => 3,
                'maxlength' => 30
            ]
        ])
        ->add('phone', IntegerType::class,
        [
            'label' => 'Phone number'
        ])
        ->add('email', TextType::class,
        [
            'label' => 'Email',
            'attr' => [
                'minlength' => 3,
                'maxlength' => 40
            ]
        ])
        ->add('image', TextType::class,
        [
            'label' => 'Image',
            'attr' => [
                'minlength' => 3,
                'maxlength' => 400
            ]
        ])
        ->add('major', EntityType::class,
        [
            'label' => 'Major',
            'required' => true,
            'class' => Major::class,
            'choice_label' => 'name',
            'multiple' => false,  
            'expanded' => false
        ])
        ->add('classes', EntityType::class,
        [
           'label' => 'Class',
           'required' => true,
           'class' => Classes::class,
            'choice_label' => 'name',
            'multiple' => false, 
            'expanded' => false
        ])
        ->add('semester', EntityType::class,
        [
            'label' => 'Semester',
            'required' => true,
            'mapped' => false,
            'class' => Semester::class,
            'choice_label' => 'name',
            'multiple' => false, 
            'expanded' => false
        ])
        ->add('course', EntityType::class,
        [
            'label' => 'Course',
            'required' => true,
            'class' => Course::class,
            'choice_label' => 'name',
            'multiple' => true, 
            'expanded' => true
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
