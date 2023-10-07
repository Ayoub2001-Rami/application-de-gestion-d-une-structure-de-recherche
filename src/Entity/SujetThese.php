<?php

namespace App\Entity;

use App\Repository\SujetTheseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SujetTheseRepository::class)]
class SujetThese
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'date')]
    private $annee;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $bourse;

    #[ORM\OneToOne(inversedBy: 'sujetThese', targetEntity: Doctorant::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $doctorant;

    #[ORM\ManyToOne(targetEntity: Professeur::class, inversedBy: 'sujetTheses')]
    #[ORM\JoinColumn(nullable: false)]
    private $encadrant;

    #[ORM\ManyToOne(targetEntity: Professeur::class)]
    private $coencadrant;

    #[ORM\OneToOne(inversedBy: 'sujetThese', targetEntity: ProjetRecherche::class, cascade: ['persist', 'remove'])]
    private $PrAssocie;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $pdf;

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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAnnee(): ?\DateTimeInterface
    {
        return $this->annee;
    }

    public function setAnnee(\DateTimeInterface $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getBourse(): ?string
    {
        return $this->bourse;
    }

    public function setBourse(?string $bourse): self
    {
        $this->bourse = $bourse;

        return $this;
    }

    public function getDoctorant(): ?Doctorant
    {
        return $this->doctorant;
    }

    public function setDoctorant(Doctorant $doctorant): self
    {
        $this->doctorant = $doctorant;

        return $this;
    }

    public function getEncadrant(): ?Professeur
    {
        return $this->encadrant;
    }

    public function setEncadrant(?Professeur $encadrant): self
    {
        $this->encadrant = $encadrant;

        return $this;
    }

    public function getCoencadrant(): ?Professeur
    {
        return $this->coencadrant;
    }

    public function setCoencadrant(?Professeur $coencadrant): self
    {
        $this->coencadrant = $coencadrant;

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
}
