<?php

namespace App\Form;

use App\Entity\Subject;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class SubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class,
        [
            'label' => 'Subject Name',
            'attr' => [
                'minlength' => 3,
                'maxlength' => 30
            ]
        ])
        ->add('info', TextType::class,
        [
            'label' => 'Description',
            'attr' => [
                'minlength' => 1,
                'maxlength' => 100
            ]
            ])
            ->add('fee', IntegerType::class,
            [
                'label' => 'Fee',
                'attr' => [
                    'min' => 100,
                    'max' => 300
            ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Subject::class,
        ]);
    }
}