<?php

namespace App\Controller;

use App\Entity\Cow;
use App\Form\CowType;
use App\Repository\CowRepository;
use Doctrine\ORM\EntityManager;
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

    /**
     * Allow us to create a new cow
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/cow/new','cow.new', methods:['GET', 'POST'])]
    public function new(Request $request,
    EntityManagerInterface $manager): Response
    {
        $cow = new Cow() ; 
        $form = $this->createForm(CowType::class, $cow);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

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

    /**
     * 
     */
    #[Route('/cow/edition/{id}','cow.edit', methods:['GET', 'POST'])]
    public function edit(
        Cow $cow, 
        Request $request,
        EntityManagerInterface $manager)
        : Response  {
       
        $form = $this->createForm(CowType::class, $cow);

        $form->handleRequest($request);

        

        if($form->isSubmitted() && $form->isValid()){
           
          
            $cow = $form->getData();
           $manager -> persist($cow); 
           $manager->flush(); 

            $this->addFlash(
             'success',
             'Vos données ont été correctement modifiées'
            ); 

            return $this->redirectToRoute('app_cow');
        }

        return $this->render('pages/cow/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    //TODO : ADD a confirm button on delete
    #[Route('/cow/suppression/{id}', 'cow.delete', methods:['GET'])]
    public function delete(EntityManagerInterface $manager, Cow $cow) : Response
    {
        if(!$cow) {
            $this->addFlash(
                'success',
                'Les données demandées pour suppression n\'ont pas été trouvées'
               ); 
        }

        $manager->remove($cow) ;
        $manager -> flush();

        $this->addFlash(
            'success',
            'Vos données ont été correctement supprimées'
           ); 

        return $this->redirectToRoute('app_cow');
    }
}
