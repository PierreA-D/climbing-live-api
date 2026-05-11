<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Security\ApiTokenManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/auth', name: 'api_auth_')]
class AuthController extends AbstractController
{
    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(
        Request $request,
        UserRepository $users,
        UserPasswordHasherInterface $passwordHasher,
        ApiTokenManager $tokenManager,
    ): JsonResponse
    {
        $payload = json_decode($request->getContent(), true);
        if (!is_array($payload)) {
            return new JsonResponse(['error' => 'Invalid payload'], Response::HTTP_BAD_REQUEST);
        }

        $identifier = isset($payload['email']) && is_string($payload['email']) ? mb_strtolower(trim($payload['email'])) : '';
        $password = isset($payload['password']) && is_string($payload['password']) ? $payload['password'] : '';

        if ($identifier === '' || $password === '') {
            return new JsonResponse(['error' => 'Email et mot de passe requis'], Response::HTTP_BAD_REQUEST);
        }

        $user = $users->findOneBy(['email' => $identifier]);
        if (!$user || !$passwordHasher->isPasswordValid($user, $password)) {
            return new JsonResponse(['error' => 'Identifiants invalides'], Response::HTTP_UNAUTHORIZED);
        }

        if (!in_array('ROLE_ADMIN', $user->getRoles(), true)) {
            return new JsonResponse(['error' => 'Acces reserve aux administrateurs'], Response::HTTP_FORBIDDEN);
        }

        $token = $tokenManager->issueToken($user);

        return new JsonResponse([
            'user' => [
                'email' => $user->getEmail(),
                'name' => $user->getEmail(),
                'role' => 'admin',
            ],
            'token' => $token['token'],
            'expiresAt' => $token['expiresAt'],
        ]);
    }
}