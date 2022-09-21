<?php

namespace App\Entity;

use App\Repository\ActorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActorRepository::class)]
class Actor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatar = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\ManyToMany(targetEntity: Movie::class, mappedBy: 'actor_id')]
    private Collection $movie_id;

    public function __construct()
    {
        $this->movie_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getMovieId(): Collection
    {
        return $this->movie_id;
    }

    public function addMovieId(Movie $movieId): self
    {
        if (!$this->movie_id->contains($movieId)) {
            $this->movie_id->add($movieId);
            $movieId->addActorId($this);
        }

        return $this;
    }

    public function removeMovieId(Movie $movieId): self
    {
        if ($this->movie_id->removeElement($movieId)) {
            $movieId->removeActorId($this);
        }

        return $this;
    }
}
