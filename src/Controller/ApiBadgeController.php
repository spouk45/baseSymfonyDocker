<?php

namespace App\Controller;

use App\Entity\Badge;
use App\Repository\BadgeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiBadgeController extends AbstractController
{
    private $security;

    public function __construct(Security $security, BadgeRepository $badgeRepository)
    {
        $this->security = $security;
    }

    #[Route('/api/badges', name: 'getBadges', methods: ['GET'])]
    public function getBadges(BadgeRepository $badgeRepository): JsonResponse
    {
        // Obtenir l'EPCI à partir du token
        $epci = $this->security->getUser();

        // Récupérer les badges associés à cet EPCI
        $badges = $badgeRepository->findBy(['epci' => $epci]);
        return $this->json($badges, 200, [], ['groups' => 'main']);
    }

    #[Route('/api/badges', name: 'createBadge', methods: ['POST'])]
    public function createBadge(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $epci = $this->security->getUser();

        $data = json_decode($request->getContent(), true);
        $name = $data['name'] ?? null;
        $authorized = $data['authorized'] ?? null;

        if ($name === null || $authorized === null) {
            return $this->json(['error' => 'Invalid input'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $badge = new Badge();
        $badge->setName($name);
        $badge->setAuthorized((bool) $authorized);
        $badge->setEpci($epci);

        $em->persist($badge);
        $em->flush();

        return $this->json(['message' => 'Badge created successfully'], JsonResponse::HTTP_CREATED);
    }
}
