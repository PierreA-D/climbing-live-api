<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity]
#[ORM\Table(name: '`athlete`')]
class Athlete
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['athlete:read', 'athlete:list', 'score:read'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['athlete:read', 'athlete:list', 'score:read'])]
    private string $firstName = '';

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['athlete:read', 'athlete:list', 'score:read'])]
    private string $lastName = '';

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(['athlete:read', 'athlete:list'])]
    private ?string $bib = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(['athlete:read', 'athlete:list'])]
    private string $category = 'open';

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getBib(): ?string
    {
        return $this->bib;
    }

    public function setBib(?string $bib): self
    {
        $this->bib = $bib;
        return $this;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
