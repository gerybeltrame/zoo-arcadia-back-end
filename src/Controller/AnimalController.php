<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Animal;

#[Route('api/animal', name: 'app_animal_')]

class AnimalController extends AbstractController
{
    #[Route(name: 'new', methods: ['POST'])]
    public function new(): Response
    {
        $animal = new Animal();
        $animal->setprenom('');
        $animal->setetat('');

        return $this->json(['message', "Animal ressource created with {$animal->getId()} id"], Response::HTTP_CREATED);


    }

    #[Route('/', name: 'show', methods: ['GET'])]
    public function show(): Response
    {

    }

    #[Route('/', name: 'edit', methods: ['PUT'])]
    public function edit(): JsonResponse
    {

    }

    #[Route('/', name: 'delete', methods: ['DELETE'])]
    public function delete(): JsonResponse
    {

    }
}
