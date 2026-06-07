<?php

namespace App\Entity;

use App\Enum\Camera\Status;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity]
#[ORM\Table(name: '`camera`')]
class Camera
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['camera:read', 'camera:list'])]
    private string $id = '';

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['camera:read', 'camera:list'])]
    private string $name = '';

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['camera:read', 'camera:list'])]
    private ?string $location = null;

    #[ORM\Column(enumType: Status::class)]
    #[Groups(['camera:read', 'camera:list'])]
    private Status $status = Status::OFFLINE;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['camera:read', 'camera:list'])]
    private ?string $rtmpUrl = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['camera:read', 'camera:list'])]
    private ?string $hlsUrl = null;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['camera:read', 'camera:list'])]
    private bool $authorized = false;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['camera:read', 'camera:list'])]
    private \DateTimeImmutable $createdAt;

    #[ORM\ManyToOne(inversedBy: 'cameras')]
    #[Groups(['camera:read', 'camera:list'])]
    private ?Competition $competition = null;

    #[ORM\Column(length: 255)]
    #[Groups(['camera:read', 'camera:list'])]
    private string $token = '';

    #[ORM\Column]
    #[Groups(['camera:read', 'camera:list'])]
    private bool $blocked = false;

    #[ORM\Column(type: 'json')]
    #[Groups(['camera:read', 'camera:list'])]
    private array $allowedPaths = [];

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    #[Groups(['camera:read', 'camera:list'])]
    private ?\DateTimeImmutable $lastSeenAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['camera:read', 'camera:list'])]
    private ?string $lastIp = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['camera:read', 'camera:list'])]
    private ?string $lastProtocol = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['camera:read', 'camera:list'])]
    private ?string $currentPath = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->lastSeenAt = new \DateTimeImmutable();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getRtmpUrl(): ?string
    {
        return $this->rtmpUrl;
    }

    public function setRtmpUrl(?string $rtmpUrl): self
    {
        $this->rtmpUrl = $rtmpUrl;
        return $this;
    }

    public function getHlsUrl(): ?string
    {
        return $this->hlsUrl;
    }

    public function setHlsUrl(?string $hlsUrl): self
    {
        $this->hlsUrl = $hlsUrl;
        return $this;
    }

    public function isAuthorized(): bool
    {
        return $this->authorized;
    }

    public function setAuthorized(bool $authorized): self
    {
        $this->authorized = $authorized;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getCompetition(): ?Competition
    {
        return $this->competition;
    }

    public function setCompetition(?Competition $competition): static
    {
        $this->competition = $competition;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function isBlocked(): ?bool
    {
        return $this->blocked;
    }

    public function setBlocked(bool $blocked): static
    {
        $this->blocked = $blocked;

        return $this;
    }

    public function getAllowedPaths(): array
    {
        return $this->allowedPaths;
    }

    public function setAllowedPaths(array $allowedPaths): static
    {
        $this->allowedPaths = $allowedPaths;

        return $this;
    }

    public function getLastSeenAt(): ?\DateTimeImmutable
    {
        return $this->lastSeenAt;
    }

    public function setLastSeenAt(?\DateTimeImmutable $lastSeenAt): static
    {
        $this->lastSeenAt = $lastSeenAt;

        return $this;
    }

    public function getLastIp(): ?string
    {
        return $this->lastIp;
    }

    public function setLastIp(?string $lastIp): static
    {
        $this->lastIp = $lastIp;

        return $this;
    }

    public function getLastProtocol(): ?string
    {
        return $this->lastProtocol;
    }

    public function setLastProtocol(?string $lastProtocol): static
    {
        $this->lastProtocol = $lastProtocol;

        return $this;
    }

    public function getCurrentPath(): ?string
    {
        return $this->currentPath;
    }

    public function setCurrentPath(?string $currentPath): static
    {
        $this->currentPath = $currentPath;

        return $this;
    }
}
