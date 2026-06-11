<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateCamera
{
    #[Assert\NotBlank]
    public string $id = '';

    #[Assert\NotBlank]
    public string $name = '';

    public ?string $location = null;

    public ?string $rtmpUrl = null;

    public ?string $hlsUrl = null;

    public bool $authorized = false;
    public string $token = '';
    public bool $blocked = false;

    #[Assert\All([
        new Assert\Type('string'),
    ])]
    public array $allowedPaths = [];

    public ?\DateTimeImmutable $lastSeenAt = null;

    public ?string $lastIp = null;

    public ?string $lastProtocol = null;

    public ?string $currentPath = null;

    #[Assert\NotBlank]
    public string $competition = '';
}