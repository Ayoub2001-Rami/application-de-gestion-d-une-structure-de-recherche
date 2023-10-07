<?php

namespace App\Entity;

use App\Repository\SujetRechercheRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SujetRechercheRepository::class)]
class SujetRecherche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\ManyToOne(targetEntity: Master::class)]
    private $master;

    #[ORM\ManyToOne(targetEntity: Stagiaire::class)]
    private $Stagiaire;

    #[ORM\Column(type: 'boolean')]
    private $pfe;

    #[ORM\Column(type: 'date')]
    private $datedebut;

    #[ORM\Column(type: 'date')]
    private $datefine;

    #[ORM\OneToOne(inversedBy: 'sujetRecherche', targetEntity: ProjetRecherche::class, cascade: ['persist', 'remove'])]
    private $PrAssocie;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $pdf;

    #[ORM\ManyToOne(targetEntity: Professeur::class, inversedBy: 'sujetRecherches')]
    #[ORM\JoinColumn(nullable: false)]
    private $Encadren;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMaster(): ?Master
    {
        return $this->master;
    }

    public function setMaster(?Master $master): self
    {
        $this->master = $master;

        return $this;
    }

    public function getStagiaire(): ?Stagiaire
    {
        return $this->Stagiaire;
    }

    public function setStagiaire(?Stagiaire $Stagiaire): self
    {
        $this->Stagiaire = $Stagiaire;

        return $this;
    }

    public function getPfe(): ?bool
    {
        return $this->pfe;
    }

    public function setPfe(bool $pfe): self
    {
        $this->pfe = $pfe;

        return $this;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->datedebut;
    }

    public function setDatedebut(\DateTimeInterface $datedebut): self
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDatefine(): ?\DateTimeInterface
    {
        return $this->datefine;
    }

    public function setDatefine(\DateTimeInterface $datefine): self
    {
        $this->datefine = $datefine;

        return $this;
    }

    public function getPrAssocie(): ?ProjetRecherche
    {
        return $this->PrAssocie;
    }

    public function setPrAssocie(?ProjetRecherche $PrAssocie): self
    {
        $this->PrAssocie = $PrAssocie;

        return $this;
    }

    public function getPdf(): ?string
    {
        return $this->pdf;
    }

    public function setPdf(?string $pdf): self
    {
        $this->pdf = $pdf;

        return $this;
    }

    public function getEncadren(): ?Professeur
    {
        return $this->Encadren;
    }

    public function setEncadren(?Professeur $Encadren): self
    {
        $this->Encadren = $Encadren;

        return $this;
    }
}
