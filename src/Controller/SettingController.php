<?php

namespace App\Controller;

use App\Dto\CreateSetting;
use App\Entity\Settings;
use App\Handler\CreateSettingHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/settings', name: 'api_settings_')]
final class SettingController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {}

    #[Route('', name: 'index')]
    public function list(): JsonResponse
    {
        $settings = $this->entityManager->getRepository(Settings::class)->findAll();
        $data = $this->serializer->serialize($settings, 'json', ['groups' => 'setting:list']);
        return new JsonResponse($data, json: true);
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create(Request $request, CreateSettingHandler $handler): JsonResponse
    {
        /** @var CreateSetting $input */
        $input = $this->serializer->deserialize(
            $request->getContent(),
            CreateSetting::class,
            'json'
        );

        $errors = $this->validator->validate($input);

        if (count($errors) > 0) {
            return $this->json([
                'message' => 'Invalid payload.',
                'errors' => (string) $errors,
            ], Response::HTTP_BAD_REQUEST);
        }

        $settings = $handler->handle($input);

        return new JsonResponse(
            $this->serializer->serialize($settings, 'json', ['groups' => ['setting:read']]),
            Response::HTTP_CREATED,
            [],
            true
        );
    }
}
