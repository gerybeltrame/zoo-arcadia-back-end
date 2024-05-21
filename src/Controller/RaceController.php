<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Race;
use App\Repository\RaceRepository;

#[Route('api/race', name: 'app_race_')]
class RaceController extends AbstractController
{
    #[Route(name: 'new', methods: ['POST'])]
    public function new(): Response
    {
        $race = new Race();
        $race->setlabel('');

        return $this->json(['message', "Race ressources created with {$race->getId()} id"], status: Response::HTTP_CREATED);

    }

    #[Route('/', name: 'show', methods: ['GET'])]
    public function show(int $id, RaceRepository $repository): Response
    {
        $race = $this->$repository->findOneBy(['id'=>$id]);
        if (!$race) {
            throw $this->createNotFoundException("No Race found for {$id} id");
        }

        return $this->json(
            ['message' => "A Race was found : {$race->getlabel()} for {$race->getId()} id"]
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
