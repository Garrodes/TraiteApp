<?php

namespace App\Controller;

use App\Entity\Cow;
use App\Entity\Mark;
use App\Form\CowType;
use App\Form\MarkType;
use Doctrine\ORM\EntityManager;
use App\Repository\CowRepository;
use App\Repository\MarkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
    #[Route('/cow', name: 'app_cow', methods:['GET'])]
    #[IsGranted('ROLE_USER')]
    public function index(
        CowRepository $repository,
         PaginatorInterface $paginator,
          Request $request,
          ): Response
    {
        
        $cows = $paginator->paginate(
           $repository -> findBy(['user'=>$this->getUser()]), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10
        );
        return $this->render('pages/cow/cow.html.twig', [
            'Cows' => $cows,
        ]);
    }


    /**
     * Display a list of cows set public 
     *
     * @param PaginatorInterface $paginator
     * @param CowRepository $repository
     * @param Request $request
     * @return Response
     */
     #[Route('/cow/public', name: 'indexPublic.cow', methods:'GET')]
    public function indexPublic(
        PaginatorInterface $paginator,
        CowRepository $repository,
        Request $request,
    ):Response
    {
        $cows = $paginator->paginate(
            $repository -> findPublicCow(null),
             $request->query->getInt('page', 1), 
             10
         );
        return $this->render('pages/cow/index_public.html.twig',[
            'Cows' => $cows ]);
    } 

    

    /**
     * Display the cow individual page, is she is declared public 
     *
     * @param Cow $cow
     * @return Response
     */
    #[Security("is_granted('ROLE_USER') and cow.isIsPublic() === true")]
    #[Route('/cow/{id}', name: 'show.cow', methods:['GET', 'POST'])]
    public function show(Cow $cow, 
    Request $request, 
    MarkRepository $markRepository,
    EntityManagerInterface $manager):Response
    {
        $mark = new Mark();

        $form = $this->createForm(MarkType::class, $mark);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
          $mark->setUser($this->getUser())
          ->setCow($cow);

          $existingMark = $markRepository -> findOneBy([
            'user'=> $this->getUser(),
            'cow' => $cow
          ]);

          
          if(!$existingMark){
            $manager->persist($mark);
          }else{
           $existingMark->setMark(
            $form->getData()->getMark()
           );
          }

          $manager ->flush();

          $this->addFlash(
            'success',
            'Entité Notée ! '
           ); 

           return $this->redirectToRoute('show.cow', ['id' => $cow->getId()]);

        }
        return $this->render('pages/cow/show.html.twig',[
            'Cow' => $cow,
        'form' => $form->createView() ]);
    } 

    /**
     * Allow us to create a new cow
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/cow/new','cow.new', methods:['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request,
    EntityManagerInterface $manager): Response
    {
        $cow = new Cow() ; 
        $form = $this->createForm(CowType::class, $cow);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

           $cow = $form->getData();
            $cow->setUser($this->getUser());

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
    #[Security("is_granted('ROLE_USER') and user === cow.getUser()")]
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
