<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column]
    private ?bool $isDone = null;


    #[ORM\Column(type: 'smallint', options: ['default' => 0])]
    private int $status = 0;
    
    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $finishedAt = null;

    #[ORM\Column(type: 'float', options: ['default' => 0])]
    private float $price = 0;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isIsDone(): ?bool
    {
        return $this->isDone;
    }

    public function setIsDone(bool $isDone): static
    {
        $this->isDone = $isDone;

        return $this;
    }

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $norma = null;

    public function getNorma(): ?float
    {
        return $this->norma;
    }

    public function setNorma(?float $norma): self
    {
        $this->norma = $norma;
        return $this;
    }

    
    public function getStatus(): int { return $this->status; }
    public function setStatus(int $status): self { $this->status = $status; return $this; }
    
    public function getFinishedAt(): ?\DateTimeInterface { return $this->finishedAt; }
    public function setFinishedAt(?\DateTimeInterface $finishedAt): self { $this->finishedAt = $finishedAt; return $this; }
    
    public function getDuration(): ?string
    {
        if (!$this->finishedAt) return null;
        $interval = $this->createdAt->diff($this->finishedAt);
        return $interval->format('%d dana, %h sati, %i min');
    }

    
    public function getPrice(): float { return $this->price; }
    public function setPrice(float $price): self { $this->price = $price; return $this; }


}
