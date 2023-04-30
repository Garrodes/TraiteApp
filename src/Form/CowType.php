<?php

namespace App\Form;

use App\Entity\Cow;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du bovin ',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                
                ]
            ])
            ->add('dob', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de Naissance',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                   
                ]])
            ->add('breed')
            ->add('ref_herd')
            // ->add('cow_health')
            ->add('submit', SubmitType::class, [
                    'attr' => [
                        'class' => 'save btn btn-primary'
                    ],
                    'label' => 'Ajouter'
                    ])
            // ->add('ref_herd')
            // ->add('breed')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cow::class,
        ]);
    }
}
