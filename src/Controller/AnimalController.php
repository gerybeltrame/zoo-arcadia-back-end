<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Animal;
use App\Repository\AnimalRepository;
use Doctrine\ORM\EntityManagerInterface;

#[Route('api/animal', name: 'app_animal_')]

class AnimalController extends AbstractController
{
    public function __construct(private AnimalRepository $repository, private EntityManagerInterface $manager)
    {
    }
    #[Route(name: 'new', methods: ['POST'])]
    public function new(): Response
    {
        $animal = new Animal();
        $animal->setprenom('');
        $animal->setetat('');

        return $this->json(['message', "Animal ressource created with {$animal->getId()} id"], Response::HTTP_CREATED);


    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, AnimalRepository $repository): Response
    {
        $animal = $this->$repository->findOneBy(['id'=>$id]);
        if (!$animal) {
            throw $this->createNotFoundException("No animal found for {$id} id");
        }

        return $this->json(
            ['message' => "An animal was found : {$animal->getprenom()} is {$animal->getetat()} for {$animal->getId()} id"]
        );

    }

    #[Route('/{id}', name: 'edit', methods: ['PUT'])]
    public function edit(int $id): Response
    {
        $animal = $this->repository->findOneBy(['id' => $id]);

        if (!$animal) {
            throw $this->createNotFoundException("No Animal found for {$id} id");
        }
        
        $animal->setprenom('Animal prenom updated');
        $animal->setetat('Animal etat updated');
        $this->manager->flush();

        return $this->redirectToRoute('app_api_animal_show', ['id' => $animal->getId()]);

    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $animal = $this->repository->findOneBy(['id' => $id]);
        if (!$animal) {
            throw $this->createNotFoundException("No Animal found for {$id} id");
        }

        $this->manager->remove($animal);
        $this->manager->flush();

        return $this->json(['message' => "Animal resource deleted"], Response::HTTP_NO_CONTENT);

    }
}
