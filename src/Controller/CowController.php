<?php

namespace App\Controller;

use App\Entity\Cow;
use App\Form\CowType;
use App\Repository\CowRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CowController extends AbstractController
{
    /**
     * This controller display all cows
     *
     * @param CowRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/cow', name: 'app_cow', methods:'GET')]
    public function index(
        CowRepository $repository,
         PaginatorInterface $paginator,
          Request $request): Response
    {
        
        $cows = $paginator->paginate(
           $repository -> findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10
        );
        return $this->render('pages/cow/cow.html.twig', [
            'Cows' => $cows,
        ]);
    }

    #[Route('/cow/new','cow.new', methods:['GET', 'POST'])]
    public function new(Request $request,
    EntityManagerInterface $manager): Response
    {
        $cow = new Cow() ; 
        $form = $this->createForm(CowType::class, $cow);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            dd($form->getData()) ;
           $cow = $form->getData();
           $manager -> persist($cow); 
           $manager->flush(); 

            $this->addFlash(
             'success',
             'Ajouté ! '
            ); 

            return $this->redirectToRoute('app_cow');
           
        }

        return $this->render('pages/cow/new.html.twig', [ 'form' => $form->createView()]);
    }
}
