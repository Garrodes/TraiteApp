<?php

namespace App\Controller;

use App\Entity\VolumeCowHerd;
use App\Repository\VolumeCowHerdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VolumeCowHerdController extends AbstractController
{
    #[Route('/milk', name: 'app_volume_cow_herd')]
    public function index( VolumeCowHerdRepository $repository): Response
    {
        $volumes = $repository -> findAll() ;

     
        return $this->render('pages/milk.html.twig', [
            'volumes' => $volumes,
        ]);
    }
}
