<?php

namespace App\Entity;

use App\Repository\QuizzRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizzRepository::class)]
class Quizz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $question1 = null;

    #[ORM\Column(length: 255)]
    private ?string $reponse11 = null;

    #[ORM\Column(length: 255)]
    private ?string $reponse12 = null;

    #[ORM\Column(length: 255)]
    private ?string $reponse13 = null;

    #[ORM\Column(length: 255)]
    private ?string $bonnereponse1 = null;

    #[ORM\Column(length: 255)]
    private ?string $userreponse1 = null;

    #[ORM\Column(length: 255)]
    private ?string $question2 = null;

    #[ORM\Column(length: 255)]
    private ?string $reponse21 = null;

    #[ORM\Column(length: 255)]
    private ?string $reponse22 = null;

    #[ORM\Column(length: 255)]
    private ?string $reponse23 = null;

    #[ORM\Column(length: 255)]
    private ?string $bonneReponse2 = null;

    #[ORM\Column(length: 255)]
    private ?string $reponseUser2 = null;

    #[ORM\Column(length: 255)]
    private ?string $question3 = null;

    #[ORM\Column(length: 255)]
    private ?string $reponse31 = null;

    #[ORM\Column(length: 255)]
    private ?string $reponse32 = null;

    #[ORM\Column(length: 255)]
    private ?string $reponse33 = null;

    #[ORM\Column(length: 255)]
    private ?string $bonneReponse3 = null;

    #[ORM\Column(length: 255)]
    private ?string $reponseUser3 = null;

    #[ORM\Column(length: 255)]
    private ?string $question4 = null;

    #[ORM\Column(length: 255)]
    private ?string $question41 = null;

    #[ORM\Column(length: 255)]
    private ?string $question42 = null;

    #[ORM\Column(length: 255)]
    private ?string $question43 = null;

    #[ORM\Column(length: 255)]
    private ?string $bonneReponse4 = null;

    #[ORM\Column(length: 255)]
    private ?string $reponseUser4 = null;

    #[ORM\Column(length: 255)]
    private ?string $question5 = null;

    #[ORM\Column(length: 255)]
    private ?string $question51 = null;

    #[ORM\Column(length: 255)]
    private ?string $question52 = null;

    #[ORM\Column(length: 255)]
    private ?string $question53 = null;

    #[ORM\Column(length: 255)]
    private ?string $bonneReponse5 = null;

    #[ORM\Column(length: 255)]
    private ?string $reponseUser5 = null;

    #[ORM\Column(length: 255)]
    private ?string $score = null;

    #[ORM\ManyToOne(inversedBy: 'quizzs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cours $cours = null;

    #[ORM\ManyToOne(inversedBy: 'quizzs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

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

    public function getQuestion1(): ?string
    {
        return $this->question1;
    }

    public function setQuestion1(string $question1): static
    {
        $this->question1 = $question1;

        return $this;
    }

    public function getReponse11(): ?string
    {
        return $this->reponse11;
    }

    public function setReponse11(string $reponse11): static
    {
        $this->reponse11 = $reponse11;

        return $this;
    }

    public function getReponse12(): ?string
    {
        return $this->reponse12;
    }

    public function setReponse12(string $reponse12): static
    {
        $this->reponse12 = $reponse12;

        return $this;
    }

    public function getReponse13(): ?string
    {
        return $this->reponse13;
    }

    public function setReponse13(string $reponse13): static
    {
        $this->reponse13 = $reponse13;

        return $this;
    }

    public function getBonnereponse1(): ?string
    {
        return $this->bonnereponse1;
    }

    public function setBonnereponse1(string $bonnereponse1): static
    {
        $this->bonnereponse1 = $bonnereponse1;

        return $this;
    }

    public function getUserreponse1(): ?string
    {
        return $this->userreponse1;
    }

    public function setUserreponse1(string $userreponse1): static
    {
        $this->userreponse1 = $userreponse1;

        return $this;
    }

    public function getQuestion2(): ?string
    {
        return $this->question2;
    }

    public function setQuestion2(string $question2): static
    {
        $this->question2 = $question2;

        return $this;
    }

    public function getReponse21(): ?string
    {
        return $this->reponse21;
    }

    public function setReponse21(string $reponse21): static
    {
        $this->reponse21 = $reponse21;

        return $this;
    }

    public function getReponse22(): ?string
    {
        return $this->reponse22;
    }

    public function setReponse22(string $reponse22): static
    {
        $this->reponse22 = $reponse22;

        return $this;
    }

    public function getReponse23(): ?string
    {
        return $this->reponse23;
    }

    public function setReponse23(string $reponse23): static
    {
        $this->reponse23 = $reponse23;

        return $this;
    }

    public function getBonneReponse2(): ?string
    {
        return $this->bonneReponse2;
    }

    public function setBonneReponse2(string $bonneReponse2): static
    {
        $this->bonneReponse2 = $bonneReponse2;

        return $this;
    }

    public function getReponseUser2(): ?string
    {
        return $this->reponseUser2;
    }

    public function setReponseUser2(string $reponseUser2): static
    {
        $this->reponseUser2 = $reponseUser2;

        return $this;
    }

    public function getQuestion3(): ?string
    {
        return $this->question3;
    }

    public function setQuestion3(string $question3): static
    {
        $this->question3 = $question3;

        return $this;
    }

    public function getReponse31(): ?string
    {
        return $this->reponse31;
    }

    public function setReponse31(string $reponse31): static
    {
        $this->reponse31 = $reponse31;

        return $this;
    }

    public function getReponse32(): ?string
    {
        return $this->reponse32;
    }

    public function setReponse32(string $reponse32): static
    {
        $this->reponse32 = $reponse32;

        return $this;
    }

    public function getReponse33(): ?string
    {
        return $this->reponse33;
    }

    public function setReponse33(string $reponse33): static
    {
        $this->reponse33 = $reponse33;

        return $this;
    }

    public function getBonneReponse3(): ?string
    {
        return $this->bonneReponse3;
    }

    public function setBonneReponse3(string $bonneReponse3): static
    {
        $this->bonneReponse3 = $bonneReponse3;

        return $this;
    }

    public function getReponseUser3(): ?string
    {
        return $this->reponseUser3;
    }

    public function setReponseUser3(string $reponseUser3): static
    {
        $this->reponseUser3 = $reponseUser3;

        return $this;
    }

    public function getQuestion4(): ?string
    {
        return $this->question4;
    }

    public function setQuestion4(string $question4): static
    {
        $this->question4 = $question4;

        return $this;
    }

    public function getQuestion41(): ?string
    {
        return $this->question41;
    }

    public function setQuestion41(string $question41): static
    {
        $this->question41 = $question41;

        return $this;
    }

    public function getQuestion42(): ?string
    {
        return $this->question42;
    }

    public function setQuestion42(string $question42): static
    {
        $this->question42 = $question42;

        return $this;
    }

    public function getQuestion43(): ?string
    {
        return $this->question43;
    }

    public function setQuestion43(string $question43): static
    {
        $this->question43 = $question43;

        return $this;
    }

    public function getBonneReponse4(): ?string
    {
        return $this->bonneReponse4;
    }

    public function setBonneReponse4(string $bonneReponse4): static
    {
        $this->bonneReponse4 = $bonneReponse4;

        return $this;
    }

    public function getReponseUser4(): ?string
    {
        return $this->reponseUser4;
    }

    public function setReponseUser4(string $reponseUser4): static
    {
        $this->reponseUser4 = $reponseUser4;

        return $this;
    }

    public function getQuestion5(): ?string
    {
        return $this->question5;
    }

    public function setQuestion5(string $question5): static
    {
        $this->question5 = $question5;

        return $this;
    }

    public function getQuestion51(): ?string
    {
        return $this->question51;
    }

    public function setQuestion51(string $question51): static
    {
        $this->question51 = $question51;

        return $this;
    }

    public function getQuestion52(): ?string
    {
        return $this->question52;
    }

    public function setQuestion52(string $question52): static
    {
        $this->question52 = $question52;

        return $this;
    }

    public function getQuestion53(): ?string
    {
        return $this->question53;
    }

    public function setQuestion53(string $question53): static
    {
        $this->question53 = $question53;

        return $this;
    }

    public function getBonneReponse5(): ?string
    {
        return $this->bonneReponse5;
    }

    public function setBonneReponse5(string $bonneReponse5): static
    {
        $this->bonneReponse5 = $bonneReponse5;

        return $this;
    }

    public function getReponseUser5(): ?string
    {
        return $this->reponseUser5;
    }

    public function setReponseUser5(string $reponseUser5): static
    {
        $this->reponseUser5 = $reponseUser5;

        return $this;
    }

    public function getScore(): ?string
    {
        return $this->score;
    }

    public function setScore(string $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(?Cours $cours): static
    {
        $this->cours = $cours;

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
}
