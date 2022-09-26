<?php

namespace App\Entity;

use App\Repository\MoviesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MoviesRepository::class)]
class Movies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank, Assert\Length(min: 5, max: 255)]
    private ?string $title = null;
    
    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank, Assert\Length(max: 2000)]
    private ?string $synopsys = null;

    #[ORM\Column]
    #[Assert\NotBlank, Assert\Positive, Assert\LessThanOrEqual(500)]
    private ?int $duration = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $youtube = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $cover = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    private ?\DateTimeImmutable $releasedAt = null;

    #[ORM\OneToMany(mappedBy: 'movieId', targetEntity: Comments::class, orphanRemoval: true)]
    private Collection $comments;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    private ?Categories $categoryId = null;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    private ?Users $userId = null;

    #[ORM\ManyToMany(targetEntity: Actors::class, inversedBy: 'movies')]
    private Collection $actors;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->actors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSynopsys(): ?string
    {
        return $this->synopsys;
    }

    public function setSynopsys(string $synopsys): self
    {
        $this->synopsys = $synopsys;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getYoutube(): ?string
    {
        return $this->youtube;
    }

    public function setYoutube(?string $youtube): self
    {
        $this->youtube = $youtube;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getReleasedAt(): ?\DateTimeImmutable
    {
        return $this->releasedAt;
    }

    public function setReleasedAt(\DateTimeImmutable $releasedAt): self
    {
        $this->releasedAt = $releasedAt;

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setMovieId($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getMovieId() === $this) {
                $comment->setMovieId(null);
            }
        }

        return $this;
    }

    public function getCategoryId(): ?Categories
    {
        return $this->categoryId;
    }

    public function setCategoryId(?Categories $categoryId): self
    {
        $this->categoryId = $categoryId;

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

    /**
     * @return Collection<int, Actors>
     */
    public function getActors(): Collection
    {
        return $this->actors;
    }

    public function addActor(Actors $actor): self
    {
        if (!$this->actors->contains($actor)) {
            $this->actors->add($actor);
        }

        return $this;
    }

    public function removeActor(Actors $actor): self
    {
        $this->actors->removeElement($actor);

        return $this;
    }
}
