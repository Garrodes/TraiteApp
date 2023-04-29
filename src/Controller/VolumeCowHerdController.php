<?php

namespace App\Controller;

use App\Entity\VolumeCowHerd;
use App\Form\VolumeCowHerdType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\VolumeCowHerdRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VolumeCowHerdController extends AbstractController
{
    /**
     * This function display all herd's milk volumes by group
     *
     * @param VolumeCowHerdRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/milk', name: 'app_volume_cow_herd', methods: ('GET'))]
    public function index( VolumeCowHerdRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $milkVolumes = $paginator->paginate(
            $repository -> findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10); /*limit per page*/

        return $this->render('pages/milk/milk.html.twig', [
            'milkVolumes' => $milkVolumes,
        ]);
    }


    #[Route('/milk/new','milk.new', methods:['GET', 'POST'])]
    public function new(Request $request,
    EntityManagerInterface $manager): Response
    {
        $milk = new VolumeCowHerd() ; 
        $form = $this->createForm(VolumeCowHerdType::class, $milk);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           $milk = $form->getData();
           $manager -> persist($milk); //like a commit
           $manager->flush(); // push

            $this->addFlash(
             'success',
             'Votre relevé a été correctement ajouté'
            ); 

            return $this->redirectToRoute('app_volume_cow_herd');
           
        }

        return $this->render('pages/milk/new.html.twig', [ 'form' => $form->createView()]);
    }
}
