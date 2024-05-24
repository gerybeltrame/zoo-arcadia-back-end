<?php

namespace App\Controller;

use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Utilisateur;

#[Route('/api', name: 'app_api_')]
class SecurityController extends AbstractController
{
    public function __construct(private EntityManagerInterface $manager, private SerializerInterface $serializer)
    {
    }

    #[Route('/enregistrement', name: 'app_enregistrement', methods: ['POST'])]
    public function enregistrement(Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $utilisateur = $this->serializer->deserialize($request->getContent(), Utilisateur::class, 'json');
        $utilisateur->setPassword($passwordHasher->hashPassword($utilisateur, $utilisateur->getPassword()));

        $this->manager->persist($utilisateur);
        $this->manager->flush();

        return new JsonResponse(
            ['user'  => $utilisateur->getUserIdentifier(), 'apiToken' => $utilisateur->getApiToken(), 'roles' => $utilisateur->getRoles()]
            ,status: Response::HTTP_CREATED);
    }
}
