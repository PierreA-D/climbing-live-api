<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

final class ApiTokenManager
{
    private const TOKEN_TTL = 60 * 60 * 12;

    public function issueToken(User $user): array
    {
        $expiresAt = time() + self::TOKEN_TTL;
        $payload = [
            'sub' => $user->getUserIdentifier(),
            'roles' => $user->getRoles(),
            'exp' => $expiresAt,
        ];

        $encodedPayload = $this->base64UrlEncode((string) json_encode($payload, JSON_THROW_ON_ERROR));
        $signature = hash_hmac('sha256', $encodedPayload, $this->secret());

        return [
            'token' => sprintf('%s.%s', $encodedPayload, $signature),
            'expiresAt' => gmdate(DATE_ATOM, $expiresAt),
        ];
    }

    public function getUserIdentifierFromToken(string $token): string
    {
        $payload = $this->verifyToken($token);

        if (!isset($payload['sub']) || !is_string($payload['sub']) || $payload['sub'] === '') {
            throw new CustomUserMessageAuthenticationException('Jeton invalide.');
        }

        return $payload['sub'];
    }

    /**
     * @return array<string, mixed>
     */
    private function verifyToken(string $token): array
    {
        $parts = explode('.', $token, 2);
        if (count($parts) !== 2) {
            throw new CustomUserMessageAuthenticationException('Jeton invalide.');
        }

        [$encodedPayload, $providedSignature] = $parts;
        $expectedSignature = hash_hmac('sha256', $encodedPayload, $this->secret());

        if (!hash_equals($expectedSignature, $providedSignature)) {
            throw new CustomUserMessageAuthenticationException('Jeton invalide.');
        }

        $decoded = $this->base64UrlDecode($encodedPayload);
        if ($decoded === false) {
            throw new CustomUserMessageAuthenticationException('Jeton invalide.');
        }

        $payload = json_decode($decoded, true);
        if (!is_array($payload) || !isset($payload['exp']) || time() >= (int) $payload['exp']) {
            throw new CustomUserMessageAuthenticationException('Jeton expire ou invalide.');
        }

        return $payload;
    }

    private function secret(): string
    {
        return $this->env('API_TOKEN_SECRET', $this->env('ADMIN_TOKEN_SECRET', $this->env('APP_SECRET', 'change-this-secret')));
    }

    private function env(string $key, string $fallback): string
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

        if (!is_string($value) || $value === '') {
            return $fallback;
        }

        return $value;
    }

    private function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }

    private function base64UrlDecode(string $value): string|false
    {
        $padding = strlen($value) % 4;
        if ($padding > 0) {
            $value .= str_repeat('=', 4 - $padding);
        }

        return base64_decode(strtr($value, '-_', '+/'), true);
    }
}