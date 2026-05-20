<?php

namespace App\Controller;

use App\Entity\Settings;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/settings', name: 'api_settings_')]
final class SettingController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
    ) {}

    #[Route('', name: 'index')]
    public function list(): JsonResponse
    {
        $settings = $this->entityManager->getRepository(Settings::class)->findAll();
        $data = $this->serializer->serialize($settings, 'json', ['groups' => 'setting:list']);
        return new JsonResponse($data, json: true);
    }
}
