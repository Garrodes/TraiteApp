<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    /**
     * This controller edits the user's pseudo & name
     */
    #[Route('/user/edition/{id}', name: 'user.edit')]
    public function index(User $user, Request $request, EntityManagerInterface $manager, 
    UserPasswordHasherInterface $hasher): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('security.login');
        }

        

        if($this->getUser() !== $user){
            return $this->redirectToRoute('home.index');
        }

        $form = $this->createForm(UserType::class, $user);

        $form ->handleRequest($request) ;


        if($form->isSubmitted() && $form->isValid()){

            if ($hasher->isPasswordValid($user, $form->getData()->getPlainPassword())) {
                $user = $form->getData();
            $manager -> persist($user); 
            $manager->flush(); 
 
             $this->addFlash(
              'success',
              'Votre profil a été correctement modifié.'
             ); 
 
             return $this->redirectToRoute('app_volume_cow_herd'); 
            }else {
                $this->addFlash(
                    'warning',
                    'Mot de Passe Incorrect'
                );

            }
          
            
         }
 

        return $this->render('pages/user/edit.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/edit/pwd/{id}', 'user.edit.pwd', methods:['GET', 'POST'])]
    public function editPassword(User $user, Request $request,
    UserPasswordHasherInterface $hasher,EntityManagerInterface $manager):Response
    {
        $form = $this->createForm(UserPasswordType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
           
            if($hasher->isPasswordValid($user, $form->getData()['plainPassword']))
            {
              
                $user ->setPassword(
                    $hasher->hashPassword(
                        $user, 
                        $form->getData()['newPassword']
                    )
                    );

               $manager->persist($user);
               $manager->flush();

                $this->addFlash(
                    'success',
                    'Votre Mot de passe a été correctement modifié'
                );

                return $this->redirectToRoute('app_volume_cow_herd'); 
            }else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe n\'a pas pu être modifié'
                );
            }

        }

      return $this->render('pages/user/edit_password.html.twig',[
        'form' => $form->createView(),
      ]); 
    }
}
