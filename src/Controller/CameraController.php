<?php

namespace App\Controller;

use App\Dto\CreateCamera;
use App\Entity\Camera;
use App\Handler\CreateCameraHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/cameras', name: 'api_camera_')]
class CameraController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {}

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $cameras = $this->entityManager->getRepository(Camera::class)->findAll();
        $data = $this->serializer->serialize($cameras, 'json', ['groups' => 'camera:list']);
        return new JsonResponse($data, json: true);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(string $id): JsonResponse
    {
        $camera = $this->entityManager->getRepository(Camera::class)->find($id);
        if (!$camera) {
            return new JsonResponse(['error' => 'Not found'], Response::HTTP_NOT_FOUND);
        }
        $data = $this->serializer->serialize($camera, 'json', ['groups' => 'camera:read']);
        return new JsonResponse($data, json: true);
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create(Request $request, CreateCameraHandler $handler): JsonResponse
    {
        /** @var CreateCamera $input */
        $input = $this->serializer->deserialize(
            $request->getContent(),
            CreateCamera::class,
            'json'
        );

        $errors = $this->validator->validate($input);

        if (count($errors) > 0) {
            return $this->json([
                'message' => 'Invalid payload.',
                'errors' => (string) $errors,
            ], Response::HTTP_BAD_REQUEST);
        }

        $camera = $handler->handle($input);

        return new JsonResponse(
            $this->serializer->serialize($camera, 'json', ['groups' => ['camera:read']]),
            Response::HTTP_CREATED,
            [],
            true
        );
    }

    #[Route('/{id}', name: 'update', methods: ['PATCH', 'PUT'])]
    public function update(string $id, Request $request): JsonResponse
    {
        $camera = $this->entityManager->getRepository(Camera::class)->find($id);
        if (!$camera) {
            return new JsonResponse(['error' => 'Not found'], Response::HTTP_NOT_FOUND);
        }
        $this->serializer->deserialize(
            $request->getContent(),
            Camera::class,
            'json',
            ['object_to_populate' => $camera]
        );
        $this->entityManager->flush();
        $data = $this->serializer->serialize($camera, 'json', ['groups' => 'camera:read']);
        return new JsonResponse($data, json: true);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(string $id): JsonResponse
    {
        $camera = $this->entityManager->getRepository(Camera::class)->find($id);
        if (!$camera) {
            return new JsonResponse(['error' => 'Not found'], Response::HTTP_NOT_FOUND);
        }
        $this->entityManager->remove($camera);
        $this->entityManager->flush();
        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
