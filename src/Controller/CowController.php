<?php

namespace App\Controller;

use App\Repository\CowRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CowController extends AbstractController
{
    #[Route('/cow', name: 'app_cow', methods:'GET')]
    public function index(CowRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        
        $cowList = $paginator->paginate(
            $repository -> findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10);
        return $this->render('pages/cow.html.twig', [
            'Cows' => $cowList,
        ]);
    }
}
