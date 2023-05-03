<?php

namespace App\Controller;

use App\Entity\InfoTraite;
use App\Form\InfoTraiteType;
use App\Repository\InfoTraiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InfoTraiteController extends AbstractController
{
    #[Route('/infotraite', name: 'index.infotraite', methods:'GET')]
    public function index(InfoTraiteRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $infotraites = $paginator->paginate(
            $repository -> findBy(['user'=>$this->getUser()]), /* query NOT result  must link info traites to users 
            $request->query->getInt('page', 1), /*page number*/
            10); /*limit per page*/

        return $this->render('pages/info_traite/infoTraite.html.twig', [
            'infotraites' => $infotraites,
        ]);
    }

    #[Route('/infotraite/new','infotraite.new', methods:['GET', 'POST'])]
    public function new(Request $request,
    EntityManagerInterface $manager): Response
    {
        $infotraite = new InfoTraite() ; 
        $form = $this->createForm(InfoTraiteType::class, $infotraite);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

           $infotraite = $form->getData();
            $infotraite->setUser($this->getUser());

           $manager -> persist($infotraite); 
           $manager->flush(); 

            $this->addFlash(
             'success',
             'Ajouté ! '
            ); 

            return $this->redirectToRoute('index.infotraite');
           
        }

        return $this->render('pages/info_traite/new.html.twig', [ 'form' => $form->createView()]);
    }

    #[Route('/infotraite/suppression/{id}', 'infotraite.delete', methods:['GET'])]
    public function delete(EntityManagerInterface $manager, InfoTraite $infotraite) : Response
    {
        if(!$infotraite) {
            $this->addFlash(
                'success',
                'Les données demandées pour suppression n\'ont pas été trouvées'
               ); 
        }

        $manager->remove($infotraite) ;
        $manager -> flush();

        $this->addFlash(
            'success',
            'Vos données ont été correctement supprimées'
           ); 

        return $this->redirectToRoute('index.infotraite');
    }
}
