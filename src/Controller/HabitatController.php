<?php

namespace App\Controller;

use App\Entity\Avis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Habitat;
use App\Repository\HabitatRepository;

#[Route('api/habitat', name: 'app_habitat_')]
class HabitatController extends AbstractController
{
    #[Route(name: 'new', methods: ['POST'])]
    public function new(): Response
    {
        $habitat= new Habitat();
        $habitat->setnom('');
        $habitat->setdescription('');
        $habitat->setcommentaireHabitat('');


        return $this->json(['message',"Habitat resource created with {$habitat->getId()} id"],Response::HTTP_CREATED);

    }

    #[Route('/', name: 'show', methods: ['GET'])]
    public function show(int $id, HabitatRepository $repository): Response
    {
        $habitat = $this->$repository->findOneBy(['id'=>$id]);
        if (!$habitat) {
            throw $this->createNotFoundException("No habitat found for {$id} id");
        }

        return $this->json(
            ['message' => "A habitat was found : {$habitat->getnom()} for {$habitat->getId()} id"]
        );

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
