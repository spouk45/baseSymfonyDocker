<?php

namespace App\EventListener;

use App\Service\ApiResponseService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ApiExceptionListener
{
    private $apiResponseService;

    public function __construct(ApiResponseService $apiResponseService)
    {
        $this->apiResponseService = $apiResponseService;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $request = $event->getRequest();
        $exception = $event->getThrowable();

        // Vérifie si l'URL commence par /accesscontrolapi
        if (strpos($request->getPathInfo(), '/accesscontrolapi') === 0) {
            // Créer une réponse JSON pour les erreurs de l'API
            $statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
            $response = $this->apiResponseService->createErrorResponse($statusCode, $exception->getMessage());

            $event->setResponse($response);
        }
    }
}
