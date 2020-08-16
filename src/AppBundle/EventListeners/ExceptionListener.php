<?php

namespace AppBundle\EventListeners;

use AppBundle\Exception\TargetNotExistsException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        if ($exception instanceof TargetNotExistsException) {
            $response = new Response;
            $response->setContent($exception->getMessage());
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);

            $event->setResponse($response);
        } elseif ($exception instanceof AccessDeniedHttpException) {
            $response = new Response;
            $response->setContent('Access Denied');
            $response->setStatusCode(Response::HTTP_FORBIDDEN);

            $event->setResponse($response);
        }
    }
}
