<?php

namespace App\Entity;

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

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['camera:read', 'camera:list'])]
    private string $location = '';

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['camera:read', 'camera:list'])]
    private string $status = 'offline';

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
    private \DateTimeImmutable $createdAt;

    #[ORM\ManyToOne(inversedBy: 'cameras')]
    private ?Competition $competition = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
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

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
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
}
