<?php

namespace App\Controller;

use App\Repository\DepotRepository;
use App\Service\ApiResponseService;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/accesscontrolapi', name: 'api_')]
class DepotController extends AbstractController
{
    private $security;
    private $depotRepository;
    private $apiResponseService;

    public function __construct(Security $security, DepotRepository $depotRepository, ApiResponseService $apiResponseService)
    {
        $this->security = $security;
        $this->depotRepository = $depotRepository;
        $this->apiResponseService = $apiResponseService;
    }

    #[Route('/depots', name: 'app_depot', methods: ['POST'])]
    public function getDepots(Request $request): JsonResponse
    {
        // Obtenir l'EPCI à partir du token
        $epci = $this->security->getUser();

        // Récupérer et valider les paramètres
        $data = json_decode($request->getContent(), true);
        $startDate = $data['startDate'] ?? null;
        $endDate = $data['endDate'] ?? null;

        if (!$startDate) {
            return $this->apiResponseService->createErrorResponse(
                JsonResponse::HTTP_BAD_REQUEST,
                'Invalid input: startDate and endDate are required.'
            );
        }

        // Convertir les dates en objets DateTime
        try {
            $startDate = new \DateTime($startDate);
            $endDate = $endDate ? new \DateTime($endDate) : new \DateTime();
        } catch (\Exception $e) {
            return $this->apiResponseService->createErrorResponse(
                JsonResponse::HTTP_BAD_REQUEST,
                'Invalid date format.'
            );
        }

        // Récupérer les depots dans l'intervalle de dates
        $depots = $this->depotRepository->findDepotsByDateRange($epci, $startDate, $endDate);
        return $this->json($depots, 200, [], ['groups' => 'main']);
    }
}
