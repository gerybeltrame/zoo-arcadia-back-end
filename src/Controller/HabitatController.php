<?php

namespace App\Controller;

use App\Entity\Avis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Habitat;
use App\Repository\HabitatRepository;
use Doctrine\ORM\EntityManagerInterface;

#[Route('api/habitat', name: 'app_habitat_')]
class HabitatController extends AbstractController
{
    public function __construct(private HabitatRepository $repository, private EntityManagerInterface $manager)
    {
    }
    #[Route(name: 'new', methods: ['POST'])]
    public function new(): Response
    {
        $habitat= new Habitat();
        $habitat->setnom('');
        $habitat->setdescription('');
        $habitat->setcommentaireHabitat('');


        return $this->json(['message',"Habitat resource created with {$habitat->getId()} id"],Response::HTTP_CREATED);

    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
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

    #[Route('/{id}', name: 'edit', methods: ['PUT'])]
    public function edit(int $id): Response
    {
        $habitat = $this->repository->findOneBy(['id' => $id]);

        if (!$habitat) {
            throw $this->createNotFoundException("No Habitat found for {$id} id");
        }
        
        $habitat->setnom('Habitat nom updated');
        $habitat->setdescription('Habitat description updated');
        $habitat->setcommentaireHabitat('Habitat commentaireHabitat updated');
        $this->manager->flush();

        return $this->redirectToRoute('app_api_habitat_show', ['id' => $habitat->getId()]);

    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $habitat = $this->repository->findOneBy(['id' => $id]);
        if (!$habitat) {
            throw $this->createNotFoundException("No Habitat found for {$id} id");
        }

        $this->manager->remove($habitat);
        $this->manager->flush();

        return $this->json(['message' => "Habitat resource deleted"], Response::HTTP_NO_CONTENT);

    }
}
