<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Avis;
use App\Repository\AvisRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('apis/avis', name: 'app_api_avis_')]

class AvisController extends AbstractController
{
    public function __construct(private AvisRepository $repository, private EntityManagerInterface $manager, private SerializerInterface $serializer, private UrlGeneratorInterface $urlGenerator)
    {
    }
    #[Route(name: 'new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $avis = $this->serializer->deserialize($request->getContent(), Avis::class, 'json');

        $avis = new Avis();
        $avis->setpseudo('Jean');
        $avis->setcommentaire('Super');

        $this->manager->persist($avis);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($avis, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_avis_show',
            ['id' => $avis->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);

    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, AvisRepository $repository): Response
    {
        $avis = $this->$repository->findOneBy(['id'=>$id]);
        if (!$avis) {
            throw $this->createNotFoundException("No avis found for {$id} id");
        }

        return $this->json(
            ['message' => "An avis was found : from {$avis->getpseudo()} of {$avis->getId()} id is visible{$avis->getIsVisible()}"]
        );

    }

    #[Route('/{id}', name: 'edit', methods: ['PUT'])]
    public function edit(int $id): Response
    {
        $avis = $this->repository->findOneBy(['id' => $id]);

        if (!$avis) {
            throw $this->createNotFoundException("No Avis found for {$id} id");
        }
        
        $avis->setpseudo('Avis pseudo updated');
        $avis->setcommentaire('Avis commentaire updated');
        $avis->setIsVisible('Avis isVisible updated');
        $this->manager->flush();

        return $this->redirectToRoute('app_api_avis_show', ['id' => $avis->getId()]);

    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $avis = $this->repository->findOneBy(['id' => $id]);
        if (!$avis) {
            throw $this->createNotFoundException("No Avis found for {$id} id");
        }

        $this->manager->remove($avis);
        $this->manager->flush();

        return $this->json(['message' => "Avis resource deleted"], Response::HTTP_NO_CONTENT);

    }


}
