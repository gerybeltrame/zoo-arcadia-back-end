<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Race;
use App\Repository\RaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('api/race', name: 'app_race_')]
class RaceController extends AbstractController
{
    public function __construct(private RaceRepository $repository, private EntityManagerInterface $manager, private SerializerInterface $serializer, private UrlGeneratorInterface $urlGenerator)
    {
    }
    #[Route(methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $race = $this->serializer->deserialize($request->getContent(), Race::class, 'json');
        $race = new Race();
        $race->setlabel('');

        $this->manager->persist($race);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($race, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_restaurant_show',
            ['id' => $race->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);

    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $race = $this->repository->findOneBy(['id'=>$id]);
        if (!$race) {
            $responseData= $this->serializer->serialize($race, 'json');

            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }

        return New JsonResponse(data: null, status: Response::HTTP_NOT_FOUND);

    }

    #[Route('/{id}', name: 'edit', methods: ['PUT'])]
    public function edit(int $id, Request $request): Response
    {
        $race = $this->repository->findOneBy(['id' => $id]);

        if (!$race) {
            $race = $this->serializer->deserialize(
                $request->getContent(), 
                Race::class, 
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $race]
            );

            $race->setlabel('Race label updated');
            $this->manager->flush();

            return New JsonResponse(data: null, status: Response::HTTP_NO_CONTENT);
        }

        return New JsonResponse(data: null, status: Response::HTTP_NOT_FOUND);

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
