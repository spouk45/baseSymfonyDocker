<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponseService
{
    public function createSuccessResponse(array $data, int $statusCode = JsonResponse::HTTP_OK): JsonResponse
    {
        return new JsonResponse($data, $statusCode);
    }

    public function createErrorResponse(string $error, string $message, int $statusCode): JsonResponse
    {
        return new JsonResponse([
            'status' => $statusCode,
            'error' => $error,
            'message' => $message
        ], $statusCode);
    }
}
