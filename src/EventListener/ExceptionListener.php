<?php

namespace App\EventListener;

use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionListener
{
    public function __construct(private Environment $twig)
    {

    }
    public function onKernelException(ExceptionEvent $event):void
    {
        $exception = $event->getThrowable();

        if(!$exception instanceof NotFoundHttpException)
        {
            return;
        }

        $content = $this->twig->render('pages/exception/not_found.html.twig', [
            'message' => $exception->getMessage(),
        ]);

        $event->setResponse((new Response())->setContent($content));
    }

}