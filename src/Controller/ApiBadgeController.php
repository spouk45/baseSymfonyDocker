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

#[Route('/accesscontrolapi', name: 'api_')]
class ApiBadgeController extends AbstractController
{
    private $security;
    private $badgeRepository;


    public function __construct(Security $security, BadgeRepository $badgeRepository)
    {
        $this->security = $security;
        $this->badgeRepository = $badgeRepository;

    }

    #[Route('/badges', name: 'getBadges', methods: ['GET'])]
    public function getBadges(): JsonResponse
    {
        // Obtenir l'EPCI à partir du token
        $epci = $this->security->getUser();

        // Récupérer les badges associés à cet EPCI
        $badges = $this->badgeRepository->findBy(['epci' => $epci]);
        return $this->json($badges, 200, [], ['groups' => 'main']);
    }

    #[Route('/badges', name: 'createBadge', methods: ['POST'])]
    public function createBadge(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $name = $data['name'] ?? null;
        $authorized = $data['authorized'] ?? null;

        if ($name === null || $authorized === null) {
            return $this->json(['error' => 'Invalid input'], JsonResponse::HTTP_BAD_REQUEST);
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
}
