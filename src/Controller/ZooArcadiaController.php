<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ZooArcadiaController extends AbstractController
{
    #[Route('/zoo/arcadia', name: 'app_zoo_arcadia')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ZooArcadiaController.php',
        ]);
    }
}
