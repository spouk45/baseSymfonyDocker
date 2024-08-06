<?php

namespace App\Controller;

use App\Repository\DepotRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/accesscontrolapi', name: 'api_')]
class DepotController extends AbstractController
{
    private $security;
    private $depotRepository;

    public function __construct(Security $security, DepotRepository $depotRepository)
    {
        $this->security = $security;
        $this->depotRepository = $depotRepository;
    }

    #[Route('/depots', name: 'app_depot')]
    public function getDepots(): JsonResponse
    {
        // Obtenir l'EPCI à partir du token
        $epci = $this->security->getUser();

        // Récupérer les badges associés à cet EPCI
        $badges = $this->depotRepository->findBy(['epci' => $epci]);
        return $this->json($badges, 200, [], ['groups' => 'main']);
    }
}
