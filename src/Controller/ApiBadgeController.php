<?php

namespace App\Controller;

use App\Entity\Badge;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class ApiBadgeController extends AbstractController
{
    #[Route('/api/badges', name: 'getBadges', methods: ['GET'])]
    public function getBadges(EntityManagerInterface $em): JsonResponse
    {
        $badges = $em->getRepository(Badge::class)->findAll();

        $data = [];
        foreach ($badges as $badge) {
            $data[] = [
                'id' => $badge->getId(),
                'name' => $badge->getName(),
                'authorized' => $badge->isAuthorized(),
            ];
        }

        return $this->json($data);
    }

    #[Route('/api/badges', name: 'createBadge', methods: ['POST'])]
    public function createBadge(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $name = $data['name'] ?? null;
        $authorized = $data['authorized'] ?? null;

        if ($name === null || $authorized === null) {
            return $this->json(['error' => 'Invalid input'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $badge = new Badge();
        $badge->setName($name);
        $badge->setAuthorized((bool) $authorized);

        $em->persist($badge);
        $em->flush();

        return $this->json(['message' => 'Badge created successfully'], JsonResponse::HTTP_CREATED);
    }
}
