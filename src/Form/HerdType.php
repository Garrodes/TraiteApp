<?php

namespace App\Form;

use App\Entity\FoodUnit;
use App\Entity\Herd;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HerdType extends AbstractType
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
                    new Assert\NotBlank(),
                ]
            ])
            ->add('water_neededforone',NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '1',
                    'maxlength' => '10',
                ],
                'label' => 'Eau nécessaire pour un élément',
                'label_attr' => [
                    'class' => 'form-label'
                ],             
                'constraints' => [
                    new Assert\Length(['min' => 1, 'max' => 10]),
                    new Assert\NotBlank(),
                ],
            ])
            ->add('food_neededforone',NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '1',
                    'maxlength' => '10',
                ],
                'label' => 'Quantité d\'aliments nécessaire pour un élement',
                'label_attr' => [
                    'class' => 'form-label'
                ],             
                'constraints' => [
                    new Assert\Length(['min' => 1, 'max' => 10]),
                    new Assert\NotBlank(),
                ],
            ])
            ->add('ref_foodUnit', EntityType::class, [
                'class' => FoodUnit::class,
                'choice_label' => 'unit' ,
                'label' => 'Unité',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                   
                ]])
                ->add('submit', SubmitType::class, [
                    'attr' => [
                        'class' => 'save btn btn-primary'
                    ],
                    'label' => 'Créer ce troupeau'
                    ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Herd::class,
        ]);
    }
}
