<?php

namespace App\Controller;

use App\Entity\VolumeCowHerd;
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

        return $this->render('pages/milk.html.twig', [
            'milkVolumes' => $milkVolumes,
        ]);
    }
}
