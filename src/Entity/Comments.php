<?php

namespace App\Entity;

use App\Repository\CommentsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentsRepository::class)]
class Comments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank, Assert\Length(max: 2000)]
    private ?string $message = null;

    #[ORM\Column]
    #[Assert\NotBlank, Assert\PositiveOrZero, Assert\LessThanOrEqual(5)]
    private ?int $note = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Movies $movieId = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?Users $userId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getMovieId(): ?Movies
    {
        return $this->movieId;
    }

    public function setMovieId(?Movies $movieId): self
    {
        $this->movieId = $movieId;

        return $this;
    }

    public function getUserId(): ?Users
    {
        return $this->userId;
    }

    public function setUserId(?Users $userId): self
    {
        $this->userId = $userId;

        return $this;
    }
}
