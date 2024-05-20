<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Avis;

#[Route('apis/avis', name: 'app_api_avis_')]

class AvisController extends AbstractController
{
    #[Route(name: 'new', methods: ['POST'])]
    public function new(): Response
    {
        $avis = new Avis();
        $avis->setpseudo('Jean');
        $avis->setcommentaire('Super');

        return $this->json(['message',"Avis resource created with {$Avis->getId()} id"],Response::HTTP_CREATED)

    }

    #[Route('/', name: 'show', methods: ['GET'])]
    public function show(): Response
    {

    }

    #[Route('/', name: 'edit', methods: ['PUT'])]
    public function edit(): Response
    {

    }

    #[Route('/', name: 'delete', methods: ['DELETE'])]
    public function delete(): Response
    {

    }


}
