<?php

namespace App\Entity;

use App\Repository\EmotionBaseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmotionBaseRepository::class)]
class EmotionBase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomEmotionBase = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEmotionBase(): ?string
    {
        return $this->nomEmotionBase;
    }

    public function setNomEmotionBase(string $nomEmotionBase): self
    {
        $this->nomEmotionBase = $nomEmotionBase;
        return $this;
    }
}
