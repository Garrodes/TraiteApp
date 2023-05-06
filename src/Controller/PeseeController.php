<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PeseeController extends AbstractController
{
    #[Route('/pesee', name: 'app_pesee')]
    public function index(): Response
    {
        return $this->render('pesee/index.html.twig', [
            'controller_name' => 'PeseeController',
        ]);
    }
}
