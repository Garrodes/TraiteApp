<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    /**
     * This controller edits the user's pseudo & name
     */
    #[Route('/user/edition/{id}', name: 'user.edit')]
    #[Security("is_granted('ROLE_USER') and user === chosenuser")]
    public function index(User $chosenuser, Request $request, EntityManagerInterface $manager, 
    UserPasswordHasherInterface $hasher): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('security.login');
        }

        

        if($this->getUser() !== $chosenuser){
            return $this->redirectToRoute('home.index');
        }

        $form = $this->createForm(UserType::class, $chosenuser);

        $form ->handleRequest($request) ;


        if($form->isSubmitted() && $form->isValid()){

            if ($hasher->isPasswordValid($chosenuser, $form->getData()->getPlainPassword())) {
                $chosenuser = $form->getData();
            $manager -> persist($chosenuser); 
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

    /**
     *  This controller allows us to edit user's password
     * (php block doc not working zzzz)
     */
    #[Route('/user/edit/pwd/{id}', 'user.edit.pwd', methods:['GET', 'POST'])]
    #[Security("is_granted('ROLE_USER') and user === chosenuser")]
    public function editPassword(User $chosenuser, 
    Request $request,
    UserPasswordHasherInterface $hasher,
    EntityManagerInterface $manager):Response
    {
        $form = $this->createForm(UserPasswordType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
           
            if($hasher->isPasswordValid($chosenuser, $form->getData()['plainPassword']))
            {
                $chosenuser ->setUpdatedAt(new \DateTimeImmutable());
                $chosenuser ->setPlainPassword(
                        $form->getData()['newPassword']
                );

               $manager->persist($chosenuser);
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
