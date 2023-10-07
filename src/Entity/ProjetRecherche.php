<?php

namespace App\Entity;

use App\Repository\ProjetRechercheRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjetRechercheRepository::class)]
class ProjetRecherche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $financement;

    #[ORM\Column(type: 'date')]
    private $dateDebut;

    #[ORM\Column(type: 'date')]
    private $Datefin;

    #[ORM\ManyToOne(targetEntity: Professeur::class)]
    private $coordinateurPrinc;

    #[ORM\OneToOne(mappedBy: 'PrAssocie', targetEntity: SujetThese::class, cascade: ['persist', 'remove'])]
    private $sujetThese;

    #[ORM\OneToOne(mappedBy: 'PrAssocie', targetEntity: SujetRecherche::class, cascade: ['persist', 'remove'])]
    private $sujetRecherche;

    #[ORM\ManyToMany(targetEntity: Membres::class, inversedBy: 'projetRecherches')]
    private $Membres;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $pdf;

    public function __construct()
    {
        $this->Membres = new ArrayCollection();
    }

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

    public function getFinancement(): ?string
    {
        return $this->financement;
    }

    public function setFinancement(string $financement): self
    {
        $this->financement = $financement;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->Datefin;
    }

    public function setDatefin(\DateTimeInterface $Datefin): self
    {
        $this->Datefin = $Datefin;

        return $this;
    }

    public function getCoordinateurPrinc(): ?Professeur
    {
        return $this->coordinateurPrinc;
    }

    public function setCoordinateurPrinc(?Professeur $coordinateurPrinc): self
    {
        $this->coordinateurPrinc = $coordinateurPrinc;

        return $this;
    }

    public function getSujetThese(): ?SujetThese
    {
        return $this->sujetThese;
    }

    public function setSujetThese(?SujetThese $sujetThese): self
    {
        // unset the owning side of the relation if necessary
        if ($sujetThese === null && $this->sujetThese !== null) {
            $this->sujetThese->setPrAssocie(null);
        }

        // set the owning side of the relation if necessary
        if ($sujetThese !== null && $sujetThese->getPrAssocie() !== $this) {
            $sujetThese->setPrAssocie($this);
        }

        $this->sujetThese = $sujetThese;

        return $this;
    }

    public function getSujetRecherche(): ?SujetRecherche
    {
        return $this->sujetRecherche;
    }

    public function setSujetRecherche(?SujetRecherche $sujetRecherche): self
    {
        // unset the owning side of the relation if necessary
        if ($sujetRecherche === null && $this->sujetRecherche !== null) {
            $this->sujetRecherche->setPrAssocie(null);
        }

        // set the owning side of the relation if necessary
        if ($sujetRecherche !== null && $sujetRecherche->getPrAssocie() !== $this) {
            $sujetRecherche->setPrAssocie($this);
        }

        $this->sujetRecherche = $sujetRecherche;

        return $this;
    }
    public function __toString(): string
    {
        // TODO: Implement __toString() method.
        return $this->getTitre();
    }

    /**
     * @return Collection<int, Membres>
     */
    public function getMembres(): Collection
    {
        return $this->Membres;
    }

    public function addMembre(Membres $membre): self
    {
        if (!$this->Membres->contains($membre)) {
            $this->Membres[] = $membre;
        }

        return $this;
    }

    public function removeMembre(Membres $membre): self
    {
        $this->Membres->removeElement($membre);

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
