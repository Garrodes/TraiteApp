<?php

namespace App\Form;

use App\Entity\Pesee;
use App\Repository\CowRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * EN CONSTRUCTION : FAIRE UN FORMULAIRE UNIQUE POUR TOUTES LES VACHES ET QUI ENVOIE D UN COUP
 */
class PeseeType extends AbstractType
{
    private $token; 


    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    } 

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('volume',NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '1',
                    'maxlength' => '10',
                ],
                'label' => 'Volume (L)',
                'label_attr' => [
                    'class' => 'form-label'
                ],             
                'constraints' => [
                    new Assert\Length(['min' => 1, 'max' => 10]),
                    new Assert\NotBlank(),
                ]])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de la pesée',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ]])
            ->add('cow', EntityType::class,[
                'query_builder'=>function(CowRepository $c){
                    return $c->createQueryBuilder('h')
                    ->where('c.user = :user')
                    ->setParameter('user', $this->token->getToken()->getUser());
                },
                'label' => 'Vache pesée',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pesee::class,
        ]);
    }
}
