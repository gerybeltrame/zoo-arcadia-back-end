<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('api/utilisateur', name: 'app_utilisateur_')]
class UtilisateurController extends AbstractController
{
    public function __construct(private UtilisateurRepository $repository, private EntityManagerInterface $manager, private SerializerInterface $serializer, private UrlGeneratorInterface $urlGenerator)
    {
    }
    #[Route(methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $utilisateur = $this->serializer->deserialize($request->getContent(), Utilisateur::class, 'json');
        $utilisateur = new Utilisateur();
        $utilisateur->setnom('');
        $utilisateur->setprenom('');
        $utilisateur->setpassword('');

        $this->manager->persist($utilisateur);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($utilisateur, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_utilisateur_show',
            ['id' => $utilisateur->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);

    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $utilisateur = $this->repository->findOneBy(['id'=>$id]);
        if (!$utilisateur) {
            $responseData= $this->serializer->serialize($utilisateur, 'json');

            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }

        return new JsonResponse(data: null, status: Response::HTTP_NOT_FOUND);

    }

    #[Route('/{id}', name: 'edit', methods: ['PUT'])]
    public function edit(int $id, Request $request): Response
    {
        $utilisateur = $this->repository->findOneBy(['id' => $id]);

        if (!$utilisateur) {
            $utilisateur = $this->serializer->deserialize(
                $request->getContent(),
                Utilisateur::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $utilisateur]
            );

            $utilisateur->setprenom('Utilisateur prenom updated');
            $utilisateur->setnom('Utilisateur nom updated');
            $utilisateur->setpassword('Utilisateur password updated');
            $this->manager->flush();

            return new JsonResponse(data: null, status: Response::HTTP_NO_CONTENT);
        }

        return new JsonResponse(data: null, status: Response::HTTP_NOT_FOUND);

    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $utilisateur = $this->repository->findOneBy(['id' => $id]);
        if (!$utilisateur) {
            throw $this->createNotFoundException("No Utilisateur found for {$id} id");
        }

        $this->manager->remove($utilisateur);
        $this->manager->flush();

        return $this->json(
            ['message' => "Utilisateur {$utilisateur->getId()} deleted"]
        );

    }
}
