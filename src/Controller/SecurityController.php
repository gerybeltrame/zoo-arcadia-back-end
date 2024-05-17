<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'app_api_')]
class SecurityController extends AbstractController
{
    #[Route('/enregistrement', name: 'app_enregistrement', methods: ['POST'])]
    public function enregistrement(): JsonResponse
    {
        return new JsonResponse([],status: Response::HTTP_CREATED);
    }
}
