<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponseService
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
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

    public function compressResponseOrNot(Request $request, $jsonResponse): JsonResponse
    {
        $acceptEncoding = $request->headers->get('Accept-Encoding');

        if (strpos($acceptEncoding, 'gzip') !== false) {
            // Compression gzip du contenu JSON
            $compressedContent = gzencode($jsonResponse->getContent());
            
            $this->logger->info('Réponse compressée avec gzip pour la requête.', [
                'request_ip' => $request->getClientIp(),
                'url' => $request->getUri(),
            ]);

            // Modifier la réponse pour indiquer qu'elle est compressée
            $jsonResponse->setContent($compressedContent);
            $jsonResponse->headers->set('Content-Encoding', 'gzip');
            $jsonResponse->headers->set('Content-Length', strlen($compressedContent));
        }

        return $jsonResponse;
    }
}
