<?php

namespace App\Controller\API;

use App\Entity\Badge;
use App\Repository\BadgeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\ApiResponseService;

#[Route('/accesscontrolapi', name: 'api_')]
class ApiBadgeController extends AbstractController
{
    private $security;
    private $badgeRepository;
    private $apiResponseService;

    public function __construct(Security $security, BadgeRepository $badgeRepository, ApiResponseService $apiResponseService)
    {
        $this->security = $security;
        $this->badgeRepository = $badgeRepository;
        $this->apiResponseService = $apiResponseService;
    }

    #[Route('/mybadges', name: 'getBadges', methods: ['GET'])]
    public function getBadges(): JsonResponse
    {
        // Obtenir l'EPCI à partir du token
        $epci = $this->security->getUser();

        // Récupérer les badges associés à cet EPCI
        $badges = $this->badgeRepository->findBy(['epci' => $epci]);
        return $this->json($badges, 200, [], ['groups' => 'main']);
    }

    #[Route('/mybadges', name: 'createBadge', methods: ['POST'])]
    public function createBadge(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $name = $data['name'] ?? null;
        $authorized = $data['authorized'] ?? null;

        if ($name === null || $authorized === null) {
            return $this->apiResponseService->createErrorResponse(
                JsonResponse::HTTP_BAD_REQUEST,
                'Invalid input',
                'The "name" and "authorized" fields are required.',

            );
        }

        $badge = $this->badgeRepository->findOneBy(['name' => $name]);
        if ($badge != null) {
            return $this->apiResponseService->createErrorResponse(
                JsonResponse::HTTP_CONFLICT,
                'Conflict',
                'This badge ever exist',

            );
        }

        $epci = $this->security->getUser();
        $badge = new Badge();
        $badge->setName($name);
        $badge->setAuthorized((bool) $authorized);
        $badge->setEpci($epci);

        $em->persist($badge);
        $em->flush();

        return $this->json(['message' => 'Badge created successfully'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/mybadges/count', name: 'getCount', methods: ['GET'])]
    public function getBadgesCount(): JsonResponse
    {
        $epci = $this->security->getUser();

        $badgeCount  = $this->badgeRepository->count(['epci' => $epci]);
        return $this->json(['badge_count' => $badgeCount]);
    }
}
