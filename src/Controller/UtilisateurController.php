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

#[Route('api/utilisateur', name: 'app_utilisateur_')]
class UtilisateurController extends AbstractController
{
    public function __construct(private UtilisateurRepository $repository, private EntityManagerInterface $manager, private SerializerInterface $serializer, private UrlGeneratorInterface $urlGenerator)
    {
    }
    #[Route(name: 'new', methods: ['POST'])]
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

    #[Route('/', name: 'show', methods: ['GET'])]
    public function show(int $id, UtilisateurRepository $repository): Response
    {
        $utilisateur = $this->$repository->findOneBy(['id'=>$id]);
        if (!$utilisateur) {
            throw $this->createNotFoundException("No utilisateur found for {$id} id");
        }

        return $this->json(
            ['message' => "An utilisateur was found : {$utilisateur->getnom()} for {$utilisateur->getId()} id"]
        );

    }

    #[Route('/', name: 'edit', methods: ['PUT'])]
    public function edit(int $id): Response
    {
        $utilisateur = $this->repository->findOneBy(['id' => $id]);

        if (!$utilisateur) {
            throw $this->createNotFoundException("No utilisateur found for {$id} id");
        }

        $utilisateur->setpassword('Utilisateur password updated');
        $utilisateur->setnom('Utilisateur nom updated');
        $utilisateur->setprenom('Utilisateur prenom updated');
        $this->manager->flush();

        return $this->redirectToRoute('app_api_utilisateur_show', ['id' => $utilisateur->getId()]);

    }

    #[Route('/', name: 'delete', methods: ['DELETE'])]
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
