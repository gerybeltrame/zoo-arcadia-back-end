<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Race;
use App\Repository\RaceRepository;
use Doctrine\ORM\EntityManagerInterface;

#[Route('api/race', name: 'app_race_')]
class RaceController extends AbstractController
{
    public function __construct(private RaceRepository $repository, private EntityManagerInterface $manager)
    {
    }
    #[Route(name: 'new', methods: ['POST'])]
    public function new(): Response
    {
        $race = new Race();
        $race->setlabel('');

        return $this->json(['message', "Race ressources created with {$race->getId()} id"], status: Response::HTTP_CREATED);

    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
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

    #[Route('/{id}', name: 'edit', methods: ['PUT'])]
    public function edit(int $id): Response
    {
        $race = $this->repository->findOneBy(['id' => $id]);

        if (!$race) {
            throw $this->createNotFoundException("No Race found for {$id} id");
        }
        
        $race->setlabel('Race label updated');
        $this->manager->flush();

        return $this->redirectToRoute('app_api_race_show', ['id' => $race->getId()]);

    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $race = $this->repository->findOneBy(['id' => $id]);
        if (!$race) {
            throw $this->createNotFoundException("No Race found for {$id} id");
        }

        $this->manager->remove($race);
        $this->manager->flush();

        return $this->json(['message' => "Race resource deleted"], Response::HTTP_NO_CONTENT);

    }
}
