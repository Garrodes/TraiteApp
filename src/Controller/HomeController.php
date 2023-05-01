<?php
namespace App\Controller;

use App\Event\CustomEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * redirect to homepage, 
     * knowledge purpose : make a timestamp on logs via a an EventListener on an Event 
     * 
     * 
     * @param EventDispatcherInterface $dispatcher
     * @return Response
     */
    #[Route('/','home.index',methods:['GET'])]
    public function index(EventDispatcherInterface $dispatcher): Response
    {
        $dispatcher->dispatch(new CustomEvent());
        
        return $this->render('pages/home.html.twig');
    }

}