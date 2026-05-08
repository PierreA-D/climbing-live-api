<?php

namespace App\Controller;

use App\Entity\Athlete;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/athletes', name: 'api_athlete_')]
class AthleteController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
    ) {}

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $athletes = $this->entityManager->getRepository(Athlete::class)->findAll();
        $data = $this->serializer->serialize($athletes, 'json', ['groups' => 'athlete:list']);
        return new JsonResponse($data, json: true);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $athlete = $this->entityManager->getRepository(Athlete::class)->find($id);
        if (!$athlete) {
            return new JsonResponse(['error' => 'Not found'], Response::HTTP_NOT_FOUND);
        }
        $data = $this->serializer->serialize($athlete, 'json', ['groups' => 'athlete:read']);
        return new JsonResponse($data, json: true);
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $athlete = $this->serializer->deserialize(
            $request->getContent(),
            Athlete::class,
            'json'
        );
        $this->entityManager->persist($athlete);
        $this->entityManager->flush();
        $data = $this->serializer->serialize($athlete, 'json', ['groups' => 'athlete:read']);
        return new JsonResponse($data, Response::HTTP_CREATED, json: true);
    }

    #[Route('/{id}', name: 'update', methods: ['PATCH', 'PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $athlete = $this->entityManager->getRepository(Athlete::class)->find($id);
        if (!$athlete) {
            return new JsonResponse(['error' => 'Not found'], Response::HTTP_NOT_FOUND);
        }
        $this->serializer->deserialize(
            $request->getContent(),
            Athlete::class,
            'json',
            ['object_to_populate' => $athlete]
        );
        $this->entityManager->flush();
        $data = $this->serializer->serialize($athlete, 'json', ['groups' => 'athlete:read']);
        return new JsonResponse($data, json: true);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $athlete = $this->entityManager->getRepository(Athlete::class)->find($id);
        if (!$athlete) {
            return new JsonResponse(['error' => 'Not found'], Response::HTTP_NOT_FOUND);
        }
        $this->entityManager->remove($athlete);
        $this->entityManager->flush();
        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
