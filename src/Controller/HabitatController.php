<?php

namespace App\Controller;

use App\Entity\Avis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Habitat;
use App\Repository\HabitatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api/habitat', name: 'app_habitat_')]
class HabitatController extends AbstractController
{
    public function __construct(private HabitatRepository $repository, private EntityManagerInterface $manager, private SerializerInterface $serializer, private UrlGeneratorInterface $urlGenerator)
    {
    }
    #[Route(name: 'new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $habitat = $this->serializer->deserialize($request->getContent(), Habitat::class, 'json');
        $habitat= new Habitat();
        $habitat->setnom('');
        $habitat->setdescription('');
        $habitat->setcommentaireHabitat('');

        $this->manager->persist($habitat);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($habitat, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_habitat_show',
            ['id' => $habitat->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);

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
