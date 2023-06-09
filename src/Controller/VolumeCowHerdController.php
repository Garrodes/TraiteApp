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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
    #[IsGranted('ROLE_USER')]
    public function index( VolumeCowHerdRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $milkVolumes = $paginator->paginate(
            $repository -> findBy(['user'=>$this->getUser()]), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10); /*limit per page*/

        return $this->render('pages/milk/milk.html.twig', [
            'milkVolumes' => $milkVolumes,
        ]);
    }



    /**
     * This is a form to add ingredient
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/milk/new','milk.new', methods:['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request,
    EntityManagerInterface $manager): Response
    {
        $milk = new VolumeCowHerd() ; 
        $form = $this->createForm(VolumeCowHerdType::class, $milk);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           $milk = $form->getData();
           $milk->setUser($this->getUser());
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

    #[Route('/milk/edition/{id}','milk.edit', methods:['GET', 'POST'])]
    #[Security("is_granted('ROLE_USER') and user === volumeCowHerd.getUser()")]
    public function edit(
        VolumeCowHerd $volumeCowHerd,
        Request $request,
        EntityManagerInterface $manager)
        : Response  {
       
        $form = $this->createForm(VolumeCowHerdType::class, $volumeCowHerd);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           $volumeCowHerd = $form->getData();
           $manager -> persist($volumeCowHerd); 
           $manager->flush(); 

            $this->addFlash(
             'success',
             'Votre relevé a été correctement modifié'
            ); 

            return $this->redirectToRoute('app_volume_cow_herd');
        }

        return $this->render('pages/milk/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    //TODO : ADD a confirm button on delete
    #[Route('/milk/suppression/{id}', 'milk.delete', methods:['GET'])]
    public function delete(EntityManagerInterface $manager, VolumeCowHerd $volumeCowHerd) : Response
    {
        if(!$volumeCowHerd) {
            $this->addFlash(
                'error',
                'Le relevé demandé n\' a pas été trouvé'
               ); 
        }

        $manager->remove($volumeCowHerd) ;
        $manager -> flush();

        $this->addFlash(
            'success',
            'Votre relevé a été correctement supprimé'
           ); 

        return $this->redirectToRoute('app_volume_cow_herd');
    }
}
