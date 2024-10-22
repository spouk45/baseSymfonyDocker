<?php

namespace App\Controller\API;

use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiStatusController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/ping', name: 'ping', methods: ['GET'])]
    public function ping(): Response
    {
        return new Response('pong', Response::HTTP_OK);
    }


    #[Route('/status', name: 'status', methods: ['GET'])]
    public function status(): Response
    {
        $epci = $this->security->getUser();
        if($epci == null){
            throw new Exception('invalid');
        }
        return new Response('Server is up and running', Response::HTTP_OK);
    }
}
