<?php

namespace App\Controller;

use App\Entity\Avis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Habitat;

#[Route('api/habitat', name: 'app_habitat_')]
class HabitatController extends AbstractController
{
    #[Route(name: 'new', methods: ['POST'])]
    public function new(): Response
    {
        $habitat= new Habitat();
        $habitat->setnom('Jean');
        $habitat->setdescription('Super');
        $habitat->setcommentaire_habitat('');


        return $this->json(['message',"Habitat resource created with {$Habitat->getId()} id"],Response::HTTP_CREATED)

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
