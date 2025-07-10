<?php

namespace App\Entity;

use App\Repository\EmotionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmotionRepository::class)]
class Emotion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomEmotion = null;

    #[ORM\ManyToOne(inversedBy: 'emotions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EmotionBase $emotionBase = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEmotion(): ?string
    {
        return $this->nomEmotion;
    }

    public function setNomEmotion(string $nomEmotion): self
    {
        $this->nomEmotion = $nomEmotion;
        return $this;
    }

    public function getEmotionBase(): ?EmotionBase
    {
        return $this->emotionBase;
    }

    public function setEmotionBase(?EmotionBase $emotionBase): self
    {
        $this->emotionBase = $emotionBase;
        return $this;
    }
}
