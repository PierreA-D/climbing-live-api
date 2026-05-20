<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity]
#[ORM\Table(name: '`settings`')]
class Settings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['setting:read', 'setting:list'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['setting:read', 'setting:list'])]
    private ?string $mediamtxApiUrl = 'http://host.docker.internal:9997';

    #[ORM\Column(length: 255)]
    #[Groups(['setting:read', 'setting:list'])]
    private ?string $hlsBaseUrl = 'http://localhost:8888';

    #[ORM\Column]
    #[Groups(['setting:read', 'setting:list'])]
    private ?bool $requireDeviceAuth = true;

    #[ORM\Column]
    #[Groups(['setting:read', 'setting:list'])]
    private ?bool $allowUnknownDevices = false;

    #[ORM\Column]
    #[Groups(['setting:read', 'setting:list'])]
    private ?bool $autoRegisterUnknownDevices = false;

    #[ORM\Column]
    #[Groups(['setting:read', 'setting:list'])]
    private ?bool $autoAuthorizeNewDevices = false;

    #[ORM\Column]
    #[Groups(['setting:read', 'setting:list'])]
    private ?bool $exposeOnlyAuthorizedPaths = false;

    #[ORM\Column]
    #[Groups(['setting:read', 'setting:list'])]
    private ?int $maxDevices = 200;

    #[ORM\Column]
    #[Groups(['setting:read', 'setting:list'])]
    private ?int $maxConnectedDevices = 20;

    #[ORM\Column]
    private ?int $deviceOfflineAfterMs = 45000;

    #[ORM\Column]
    #[Groups(['setting:read', 'setting:list'])]
    private ?int $pollIntervalMs = 10000;

    #[ORM\Column]
    #[Groups(['setting:read', 'setting:list'])]
    private ?bool $enablePublish = true;

    #[ORM\Column]
    #[Groups(['setting:read', 'setting:list'])]
    private ?bool $enableRead = true;

    #[ORM\Column]
    #[Groups(['setting:read', 'setting:list'])]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column]
    #[Groups(['setting:read', 'setting:list'])]
    private \DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $now = new \DateTimeImmutable();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMediamtxApiUrl(): ?string
    {
        return $this->mediamtxApiUrl;
    }

    public function setMediamtxApiUrl(string $mediamtxApiUrl): static
    {
        $this->mediamtxApiUrl = $mediamtxApiUrl;

        return $this;
    }

    public function getHlsBaseUrl(): ?string
    {
        return $this->hlsBaseUrl;
    }

    public function setHlsBaseUrl(string $hlsBaseUrl): static
    {
        $this->hlsBaseUrl = $hlsBaseUrl;

        return $this;
    }

    public function isRequireDeviceAuth(): ?bool
    {
        return $this->requireDeviceAuth;
    }

    public function setRequireDeviceAuth(bool $requireDeviceAuth): static
    {
        $this->requireDeviceAuth = $requireDeviceAuth;

        return $this;
    }

    public function isAllowUnknownDevices(): ?bool
    {
        return $this->allowUnknownDevices;
    }

    public function setAllowUnknownDevices(bool $allowUnknownDevices): static
    {
        $this->allowUnknownDevices = $allowUnknownDevices;

        return $this;
    }

    public function isAutoRegisterUnknownDevices(): ?bool
    {
        return $this->autoRegisterUnknownDevices;
    }

    public function setAutoRegisterUnknownDevices(bool $autoRegisterUnknownDevices): static
    {
        $this->autoRegisterUnknownDevices = $autoRegisterUnknownDevices;

        return $this;
    }

    public function isAutoAuthorizeNewDevices(): ?bool
    {
        return $this->autoAuthorizeNewDevices;
    }

    public function setAutoAuthorizeNewDevices(bool $autoAuthorizeNewDevices): static
    {
        $this->autoAuthorizeNewDevices = $autoAuthorizeNewDevices;

        return $this;
    }

    public function isExposeOnlyAuthorizedPaths(): ?bool
    {
        return $this->exposeOnlyAuthorizedPaths;
    }

    public function setExposeOnlyAuthorizedPaths(bool $exposeOnlyAuthorizedPaths): static
    {
        $this->exposeOnlyAuthorizedPaths = $exposeOnlyAuthorizedPaths;

        return $this;
    }

    public function getMaxDevices(): ?int
    {
        return $this->maxDevices;
    }

    public function setMaxDevices(int $maxDevices): static
    {
        $this->maxDevices = $maxDevices;

        return $this;
    }

    public function getMaxConnectedDevices(): ?int
    {
        return $this->maxConnectedDevices;
    }

    public function setMaxConnectedDevices(int $maxConnectedDevices): static
    {
        $this->maxConnectedDevices = $maxConnectedDevices;

        return $this;
    }

    public function getDeviceOfflineAfterMs(): ?int
    {
        return $this->deviceOfflineAfterMs;
    }

    public function setDeviceOfflineAfterMs(int $deviceOfflineAfterMs): static
    {
        $this->deviceOfflineAfterMs = $deviceOfflineAfterMs;

        return $this;
    }

    public function getPollIntervalMs(): ?int
    {
        return $this->pollIntervalMs;
    }

    public function setPollIntervalMs(int $pollIntervalMs): static
    {
        $this->pollIntervalMs = $pollIntervalMs;

        return $this;
    }

    public function isEnablePublish(): ?bool
    {
        return $this->enablePublish;
    }

    public function setEnablePublish(bool $enablePublish): static
    {
        $this->enablePublish = $enablePublish;

        return $this;
    }

    public function isEnableRead(): ?bool
    {
        return $this->enableRead;
    }

    public function setEnableRead(bool $enableRead): static
    {
        $this->enableRead = $enableRead;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
