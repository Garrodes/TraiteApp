<?php

namespace App\Form;

use App\Entity\Cow;
use App\Entity\InfoTraite;
use App\Repository\CowRepository;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class InfoTraiteType extends AbstractType
{

    private $token; 


    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    } 

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', TextType::class, [
                'label' => 'Informations ',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])
            ->add('relatedCows', EntityType::class, [
                'class' => Cow::class,
                    'query_builder' => function (CowRepository $c) {
 return $c->createQueryBuilder('c')
     ->where('c.user = :user')
    ->orderBy('c.name', 'ASC')
    ->setParameter('user', $this->token->getToken()->getUser());
},
         'choice_label' => 'name' ,
         'multiple' => true,
         'expanded' => true,
         'label' => ' Vache concernée ',
         'label_attr' => [
             'class' => 'form-label',
         ]])
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
            'data_class' => InfoTraite::class,
        ]);
    }
}
