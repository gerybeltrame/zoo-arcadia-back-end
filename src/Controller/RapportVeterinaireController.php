<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\RapportVeterinaire;
use App\Repository\RapportVeterinaireRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

#[Route('api/rapportVeterinaire', name: 'app_rapportVeterinaire_')]
class RapportVeterinaireController extends AbstractController
{
    public function __construct(private RapportVeterinaireRepository $repository, private EntityManagerInterface $manager, private SerializerInterface $serializer, private UrlGeneratorInterface $urlGenerator)
    {
    }
    #[Route(methods: ['POST'])]
    public function new(Request $request): Response
    {
        $rapportVeterinaire = $this->serializer->deserialize($request->getContent(), RapportVeterinaire::class, 'json');
        $rapportVeterinaire = new RapportVeterinaire();
        $rapportVeterinaire->setdate(new DateTimeImmutable());
        $rapportVeterinaire->setdetail('');

        $this->manager->persist($rapportVeterinaire);
        $this->manager->flush();

        $responseData = $this->serializer->serialize($rapportVeterinaire, 'json');
        $location = $this->urlGenerator->generate(
            'app_api_rapportveterinaire_show',
            ['id' => $rapportVeterinaire->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL,
        );

        return new JsonResponse($responseData, Response::HTTP_CREATED, ["Location" => $location], true);

    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $rapportveterinaire = $this->repository->findOneBy(['id'=>$id]);
        if (!$rapportveterinaire) {
            $responseData= $this->serializer->serialize($rapportveterinaire, 'json');

            return new JsonResponse($responseData, Response::HTTP_OK, [], true);
        }

        return New JsonResponse(data: null, status: Response::HTTP_NOT_FOUND);

    }

    #[Route('/{id}', name: 'edit', methods: ['PUT'])]
    public function edit(int $id, Request $request): Response
    {
        $rapportveterinaire = $this->repository->findOneBy(['id' => $id]);

        if (!$rapportveterinaire) {
            $rapportveterinaire = $this->serializer->deserialize(
                $request->getContent(), 
                RapportVeterinaire::class, 
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $rapportveterinaire]
            );

            $rapportveterinaire->setdate(new DateTimeImmutable());
            $rapportveterinaire->setdetail('Rapport du vétérinaire detail updated');
            $this->manager->flush();

            return New JsonResponse(data: null, status: Response::HTTP_NO_CONTENT);
        }

        return New JsonResponse(data: null, status: Response::HTTP_NOT_FOUND);

    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $rapportveterinaire = $this->repository->findOneBy(['id' => $id]);
        if (!$rapportveterinaire) {
            throw $this->createNotFoundException("No Rapport veterinaire found for {$id} id");
        }

        $this->manager->remove($rapportveterinaire);
        $this->manager->flush();

        return $this->json(['message' => "Rapport vétérinaire resource deleted"], Response::HTTP_NO_CONTENT);

    }
}
