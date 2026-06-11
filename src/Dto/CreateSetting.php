<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateSetting
{
    public ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Url]
    public string $mediamtxApiUrl = 'http://host.docker.internal:9997';

    #[Assert\NotBlank]
    #[Assert\Url]
    public string $hlsBaseUrl = 'http://localhost:8888';

    public bool $requireDeviceAuth = true;

    public bool $allowUnknownDevices = false;

    public bool $autoRegisterUnknownDevices = false;

    public bool $autoAuthorizeNewDevices = false;

    public bool $exposeOnlyAuthorizedPaths = false;

    #[Assert\Positive]
    public int $maxDevices = 200;

    #[Assert\Positive]
    public int $maxConnectedDevices = 20;

    #[Assert\Positive]
    public int $deviceOfflineAfterMs = 45000;

    #[Assert\Positive]
    public int $pollIntervalMs = 10000;

    public bool $enablePublish = true;

    public bool $enableRead = true;

    public ?\DateTimeImmutable $createdAt = null;

    public ?\DateTimeImmutable $updatedAt = null;
}