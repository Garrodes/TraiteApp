<?php

namespace App\Controller;

use App\Repository\CowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PeseeController extends AbstractController
{
    #[Route('/pesee', name: 'index.pesee')]
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
        return $this->render('pages/pesee/index.html.twig', [
            'cows' => $cows,
        ]);
    }
}
