<?php

namespace App\Form;

use App\Entity\Cow;
use App\Entity\Herd;
use App\Entity\Breed;
use App\Entity\Health;
use App\Repository\HerdRepository;
use App\Repository\HealthRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CowType extends AbstractType
{

/*  Needed if I wanted the user to create a cow with his own health state that he defined which is not the case
    It will be reused on a form to change a cow's herd */
private $token; 


    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    } 




    /**
     * form to add a new cow to db 
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
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
                'query_builder' => function(HerdRepository $h){
                    return $h->createQueryBuilder('h')
                    ->where('h.user = :user')
                    ->setParameter('user', $this->token->getToken()->getUser());
                },
                'class' => Herd::class,
                'choice_label' => 'name' ,
                'label' => 'Troupeau',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
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
                 'label' => 'Etat de santé de la vache : ',
                 'label_attr' => [
                     'class' => 'form-label'
                 ],     
                 ]) 
            ->add('idNat', NumberType::class,[
                'label' => 'Numéro d\'Identification',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'html5'=>true,
                'constraints' => [
                
                ]
            ])
            ->add('isPublic', CheckboxType::class, [
                'label'=>'Rendre les informations de ce bovin publiques ?',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'required' => 'false'
            ])
            ->add('imageFile', VichImageType::class,[
                'label' => 'Photo de la vache ',
                'label_attr' => [
                    'class'=> 'form-label mt-4',
                ],
                'required' => false
            ])
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
