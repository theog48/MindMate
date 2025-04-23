<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 5000)]
    private ?string $contenu = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'cours')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, Quizz>
     */
    #[ORM\OneToMany(targetEntity: Quizz::class, mappedBy: 'cours', orphanRemoval: true)]
    private Collection $quizzs;

    /**
     * @var Collection<int, MotCle>
     */
    #[ORM\ManyToMany(targetEntity: MotCle::class, mappedBy: 'cours')]
    private Collection $motCles;

    public function __construct()
    {
        $this->quizzs = new ArrayCollection();
        $this->motCles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getCreateatdatetime(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreateatdatetime(\DateTimeInterface $createdAt): static
    {
        $this->createatdatetime = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Quizz>
     */
    public function getQuizzs(): Collection
    {
        return $this->quizzs;
    }

    public function addQuizz(Quizz $quizz): static
    {
        if (!$this->quizzs->contains($quizz)) {
            $this->quizzs->add($quizz);
            $quizz->setCours($this);
        }

        return $this;
    }

    public function removeQuizz(Quizz $quizz): static
    {
        if ($this->quizzs->removeElement($quizz)) {
            // set the owning side to null (unless already changed)
            if ($quizz->getCours() === $this) {
                $quizz->setCours(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MotCle>
     */
    public function getMotCles(): Collection
    {
        return $this->motCles;
    }

    public function addMotCle(MotCle $motCle): static
    {
        if (!$this->motCles->contains($motCle)) {
            $this->motCles->add($motCle);
            $motCle->addCour($this);
        }

        return $this;
    }

    public function removeMotCle(MotCle $motCle): static
    {
        if ($this->motCles->removeElement($motCle)) {
            $motCle->removeCour($this);
        }

        return $this;
    }
}
