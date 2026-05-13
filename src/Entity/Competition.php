<?php

namespace App\Entity;

use App\Enum\Competition\Category;
use App\Enum\Competition\Status;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity]
#[ORM\Table(name: '`competition`')]
class Competition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['competition:read', 'competition:list'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['competition:read', 'competition:list'])]
    private string $name = '';

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['competition:read', 'competition:list'])]
    private ?string $location = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['competition:read', 'competition:list'])]
    private \DateTimeImmutable $startAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    #[Groups(['competition:read', 'competition:list'])]
    private ?\DateTimeImmutable $endAt = null;

    #[ORM\Column(enumType: Status::class, nullable: true)]
    #[Groups(['competition:read', 'competition:list'])]
    private ?Status $status = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    /**
     * @var Collection<int, Camera>
     */
    #[ORM\OneToMany(targetEntity: Camera::class, mappedBy: 'competition', cascade: ['remove', 'persist'])]
    #[Groups(['competition:read', 'competition:list'])]
    private Collection $cameras;

    #[ORM\Column(enumType: Category::class, nullable: true)]
    #[Groups(['competition:read', 'competition:list'])]
    private ?Category $category = null;

    public function __construct()
    {
        $this->startAt = new \DateTimeImmutable();
        $this->createdAt = new \DateTimeImmutable();
        $this->cameras = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStartAt(): \DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): self
    {
        $this->startAt = $startAt;
        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeImmutable $endAt): self
    {
        $this->endAt = $endAt;
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

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return Collection<int, Camera>
     */
    public function getCameras(): Collection
    {
        return $this->cameras;
    }

    public function addCamera(Camera $camera): static
    {
        if (!$this->cameras->contains($camera)) {
            $this->cameras->add($camera);
            $camera->setCompetition($this);
        }

        return $this;
    }

    public function removeCamera(Camera $camera): static
    {
        if ($this->cameras->removeElement($camera)) {
            if ($camera->getCompetition() === $this) {
                $camera->setCompetition(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): static
    {
        $this->category = $category;

        return $this;
    }
}
