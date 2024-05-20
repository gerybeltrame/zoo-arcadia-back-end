<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Utilisateur;

#[Route('api/utilisateur', name: 'app_utilisateur_')]
class UtilisateurController extends AbstractController
{
    #[Route(name: 'new', methods: ['POST'])]
    public function new(): Response
    {
        $utilisateur = new Utilisateur();
        $utilisateur->setnom('');
        $utilisateur->setprenom('');
        $utilisateur->setpassword('');

        return $this->json(['message', "Utilisateur ressource created with {$utilisateur->getId()} id"], status: Response::HTTP_CREATED);

    }

    #[Route('/', name: 'show', methods: ['GET'])]
    public function show(): Response
    {

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
