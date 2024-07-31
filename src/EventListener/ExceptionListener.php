<?php

namespace App\EventListener;

use App\Service\ApiResponseService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    private $apiResponseService;

    public function __construct(ApiResponseService $apiResponseService)
    {
        $this->apiResponseService = $apiResponseService;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
        $response = $this->apiResponseService->createErrorResponse($statusCode, $exception->getMessage());

        $event->setResponse($response);
    }
}
