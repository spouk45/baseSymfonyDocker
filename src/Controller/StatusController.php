<?php

namespace App\Controller;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StatusController extends AbstractController
{
    #[Route('/ping', name: 'ping', methods: ['GET'])]
    public function ping(): Response
    {
        return new Response('pong', Response::HTTP_OK);
    }


    #[Route('/status', name: 'status', methods: ['GET'])]
    public function status(Security $security): Response
    {
        return new Response('Server is up and running', Response::HTTP_OK);
    }
}
