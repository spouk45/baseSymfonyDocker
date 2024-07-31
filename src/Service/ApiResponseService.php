<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponseService
{
    public function createSuccessResponse(int $statusCode = JsonResponse::HTTP_OK, array $data ): JsonResponse
    {
        return new JsonResponse($data, $statusCode);
    }

    public function createErrorResponse(int $code, ?string $message = null, ?string $detail = null): JsonResponse
    {
        $responseArray = [
            'error' => [
                'code' => $code,
            ]
        ];

        if ($message !== null) {
            $responseArray['error']['message'] = $message;
        }
        if ($detail !== null) {
            $responseArray['error']['detail'] = $message;
        }

        return new JsonResponse($responseArray, $code);
    }
}
