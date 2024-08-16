<?php

namespace App\Controller\API;

use App\Utils\DateTimeUtils;
use Psr\Log\LoggerInterface;
use App\Repository\DepotRepository;
use App\Service\ApiResponseService;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/accesscontrolapi', name: 'api_')]
class ApiDepotController extends AbstractController
{
    private $security;
    private $depotRepository;
    private $apiResponseService;
    private $logger;

    public function __construct(Security $security, DepotRepository $depotRepository, ApiResponseService $apiResponseService, LoggerInterface $logger)
    {
        $this->security = $security;
        $this->depotRepository = $depotRepository;
        $this->apiResponseService = $apiResponseService;
        $this->logger = $logger;
    }

    /**
     * Retrieves depot records for the authenticated EPCI within a specified date range.
     *
     * This method handles POST requests to fetch depot data filtered by `startDate` and `endDate`.
     * If `endDate` is not provided, the current date and time will be used as the default.
     * The `startDate` and `endDate` should be in ISO 8601 format or timestamp format.
     *
     * @param Request $request The HTTP request object containing the date range parameters.
     * @return JsonResponse The JSON response containing the filtered depot records.
     */
    #[Route('/depots', name: 'app_depot', methods: ['POST'])]
    public function getDepots(Request $request): JsonResponse
    {
        $epci = $this->security->getUser();

        // Log the request details
        $this->logger->info('Received request for getDepots', [
            'time' => date('Y-m-d H:i:s'),
            'ip' => $request->getClientIp(),
            'data' => $request->getContent()
        ]);

        $data = json_decode($request->getContent(), true);
        $startDateInput = $data['startDate'] ?? null;
        $endDateInput = $data['endDate'] ?? null;

        $startDate = DateTimeUtils::convertToDateTime($startDateInput);
        $endDate = DateTimeUtils::convertToDateTime($endDateInput ?? 'now');

        if ($startDate === null || $endDate === null) {
            return $this->apiResponseService->createErrorResponse(
                JsonResponse::HTTP_BAD_REQUEST,
                'Invalid input: startDate and endDate are required.'
            );
        }

        // Récupérer les depots dans l'intervalle de dates
        $depots = $this->depotRepository->findDepotsByDateRange($epci, $startDate, $endDate);
        
        // Log the response details
        $this->logger->info('Sending response for getDepots', [
            'time' => date('Y-m-d H:i:s'),
            'count' => count($depots)
        ]);

        return $this->json($depots, 200, [], ['groups' => 'main']);
    }
}
