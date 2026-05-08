<?php

namespace App\Controller;

use App\Entity\Competition;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/competitions', name: 'api_competition_')]
class CompetitionController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
    ) {}

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $competitions = $this->entityManager->getRepository(Competition::class)->findAll();
        $data = $this->serializer->serialize($competitions, 'json', ['groups' => 'competition:list']);
        return new JsonResponse($data, json: true);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $competition = $this->entityManager->getRepository(Competition::class)->find($id);
        if (!$competition) {
            return new JsonResponse(['error' => 'Not found'], Response::HTTP_NOT_FOUND);
        }
        $data = $this->serializer->serialize($competition, 'json', ['groups' => 'competition:read']);
        return new JsonResponse($data, json: true);
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $competition = $this->serializer->deserialize(
            $request->getContent(),
            Competition::class,
            'json'
        );
        $this->entityManager->persist($competition);
        $this->entityManager->flush();
        $data = $this->serializer->serialize($competition, 'json', ['groups' => 'competition:read']);
        return new JsonResponse($data, Response::HTTP_CREATED, json: true);
    }

    #[Route('/{id}', name: 'update', methods: ['PATCH', 'PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $competition = $this->entityManager->getRepository(Competition::class)->find($id);
        if (!$competition) {
            return new JsonResponse(['error' => 'Not found'], Response::HTTP_NOT_FOUND);
        }
        $this->serializer->deserialize(
            $request->getContent(),
            Competition::class,
            'json',
            ['object_to_populate' => $competition]
        );
        $this->entityManager->flush();
        $data = $this->serializer->serialize($competition, 'json', ['groups' => 'competition:read']);
        return new JsonResponse($data, json: true);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $competition = $this->entityManager->getRepository(Competition::class)->find($id);
        if (!$competition) {
            return new JsonResponse(['error' => 'Not found'], Response::HTTP_NOT_FOUND);
        }
        $this->entityManager->remove($competition);
        $this->entityManager->flush();
        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
