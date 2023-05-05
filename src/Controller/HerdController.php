<?php

namespace App\Controller;

use App\Entity\Herd;
use App\Form\HerdType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HerdController extends AbstractController
{
    #[Route('/herd', name: 'index.herd')]
    public function index(): Response
    {
        return $this->render('pages/herd/index.html.twig', [
            'controller_name' => 'HerdController',
        ]);
    }

    #[Route('/herd/new', name:'new.herd')]
    #[IsGranted('ROLE_USER')]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ):Response
    {
        $herd = new Herd() ;
        $form = $this->createForm(HerdType::class, $herd);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

           $herd = $form->getData();
            $herd->setUser($this->getUser());
           $manager -> persist($herd); 
           $manager->flush(); 

            $this->addFlash(
             'success',
             'Ajouté ! '
            ); 

            return $this->redirectToRoute('index.herd');
           
        }

        return $this->render('pages/herd/new.html.twig', [ 'form' => $form->createView()]);
    }

    #[Route('/herd/edit', 'edit.herd', methods:['POST','GET'])]
    #[IsGranted('ROLE_USER')]
    public function edit(
        Herd $herd,
        Request $request,
        EntityManagerInterface $manager
    ):Response
    {
    
        $form = $this->createForm(HerdType::class, $herd);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

           $herd = $form->getData();
            $herd->setUser($this->getUser());

           $manager -> persist($herd); 
           $manager->flush(); 

            $this->addFlash(
             'success',
             'Modification prise en compte '
            ); 

            return $this->redirectToRoute('index.herd');
           
        }

        return $this->render('pages/herd/edit.html.twig', [ 'form' => $form->createView()]);
    }


    #[Route('/herd/new', 'new.herd', methods:['GET'])]
    #[IsGranted('ROLE_USER')]
    public function delete(EntityManager $manager, Herd $herd):Response
    {
        if(!$herd){
            $this->addFlash(
                'error',
                'Les données demandées pour suppression n\'ont pas été trouvées'
               ); 
        }

        $manager->remove($herd);
        $manager->flush();

        $this->addFlash(
            'success',
            'Vos données ont été correctement supprimées'
           ); 

        return $this->render('index.herd');
    }
}
