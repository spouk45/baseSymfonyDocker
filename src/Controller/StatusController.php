<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StatusController extends AbstractController
{
    #[Route('/status', name: 'status', methods: ['GET'])]
    public function status(): Response
    {
        return new Response('Server is up and running', Response::HTTP_OK);
    }
}
