<?php

namespace App\Form;

use App\Entity\Cow;
use App\Entity\Herd;
use App\Entity\Breed;
use App\Entity\Health;
use App\Entity\InfoTraite;
use App\Repository\HealthRepository;
use App\Repository\InfoTraiteRepository;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('breed',EntityType::class, [
                'class' => Breed::class,
                'choice_label' => 'name' ,
                'label' => 'Race',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                   
                ]])
            ->add('ref_herd',EntityType::class, [
                'class' => Herd::class,
                'choice_label' => 'name' ,
                'label' => 'Troupeau',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                   
                ]]
                )
             ->add('healths', EntityType::class, [
                        'class' => Health::class,
                            'query_builder' => function (HealthRepository $er) {
         return $er->createQueryBuilder('h')
            ->orderBy('h.state', 'ASC');
    },
                 'choice_label' => 'state' ,
                 'multiple' => true,
                 'expanded' => true,
                 'label' => 'Etat de santé de la vache ',
                 'label_attr' => [
                     'class' => 'form-label'
                 ],
                 
                 ]) 
//                 ->add('cow_infotraite', EntityType::class, [
//                     'class' => InfoTraite::class,
//                         'query_builder' => function (InfoTraiteRepository $er) {
//      return $er->createQueryBuilder('i')
//          ->orderBy('i.type', 'ASC');
//  },
//              'choice_label' => 'type' ,
//              'multiple' => true,
//              'expanded' => true,
//              'label' => 'Info Traite',
//              'label_attr' => [
//                  'class' => 'form-label'
//              ],
//              'mapped' => false,
//              'constraints' => [
                
//              ]]) 
            ->add('submit', SubmitType::class, [
                    'attr' => [
                        'class' => 'save btn btn-primary'
                    ],
                    'label' => 'Ajouter'
                    ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cow::class,
        ]);
    }
}
