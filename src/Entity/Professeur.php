<?php

namespace App\Entity;

use App\Repository\ProfesseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfesseurRepository::class)]
class Professeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(targetEntity: Membres::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $id_membre;

    #[ORM\OneToMany(mappedBy: 'encadrant', targetEntity: SujetThese::class)]
    private $sujetTheses;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $prenom;

    #[ORM\OneToMany(mappedBy: 'chef', targetEntity: Equipe::class)]
    private $equipes;

    #[ORM\OneToMany(mappedBy: 'Encadren', targetEntity: SujetRecherche::class)]
    private $sujetRecherches;

    public function __construct()
    {
        $this->sujetTheses = new ArrayCollection();
        $this->equipes = new ArrayCollection();
        $this->sujetRecherches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMembre(): ?Membres
    {
        return $this->id_membre;
    }

    public function setIdMembre(Membres $id_membre): self
    {
        $this->id_membre = $id_membre;

        return $this;
    }

    /**
     * @return Collection<int, SujetThese>
     */
    public function getSujetTheses(): Collection
    {
        return $this->sujetTheses;
    }

    public function addSujetThesis(SujetThese $sujetThesis): self
    {
        if (!$this->sujetTheses->contains($sujetThesis)) {
            $this->sujetTheses[] = $sujetThesis;
            $sujetThesis->setEncadrant($this);
        }

        return $this;
    }

    public function removeSujetThesis(SujetThese $sujetThesis): self
    {
        if ($this->sujetTheses->removeElement($sujetThesis)) {
            // set the owning side to null (unless already changed)
            if ($sujetThesis->getEncadrant() === $this) {
                $sujetThesis->setEncadrant(null);
            }
        }

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }
    public function __toString(): string
    {
        // TODO: Implement __toString() method.
        return $this->getNom()." ".$this->getPrenom();
    }

    /**
     * @return Collection<int, Equipe>
     */
    public function getEquipes(): Collection
    {
        return $this->equipes;
    }

    public function addEquipe(Equipe $equipe): self
    {
        if (!$this->equipes->contains($equipe)) {
            $this->equipes[] = $equipe;
            $equipe->setChef($this);
        }

        return $this;
    }

    public function removeEquipe(Equipe $equipe): self
    {
        if ($this->equipes->removeElement($equipe)) {
            // set the owning side to null (unless already changed)
            if ($equipe->getChef() === $this) {
                $equipe->setChef(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SujetRecherche>
     */
    public function getSujetRecherches(): Collection
    {
        return $this->sujetRecherches;
    }

    public function addSujetRecherch(SujetRecherche $sujetRecherch): self
    {
        if (!$this->sujetRecherches->contains($sujetRecherch)) {
            $this->sujetRecherches[] = $sujetRecherch;
            $sujetRecherch->setEncadren($this);
        }

        return $this;
    }

    public function removeSujetRecherch(SujetRecherche $sujetRecherch): self
    {
        if ($this->sujetRecherches->removeElement($sujetRecherch)) {
            // set the owning side to null (unless already changed)
            if ($sujetRecherch->getEncadren() === $this) {
                $sujetRecherch->setEncadren(null);
            }
        }

        return $this;
    }
}
