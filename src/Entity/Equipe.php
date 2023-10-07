<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\ManyToOne(targetEntity: Professeur::class, inversedBy: 'equipes')]
    #[ORM\JoinColumn(nullable: false)]
    private $chef;

    #[ORM\ManyToMany(targetEntity: Membres::class, inversedBy: 'Mequipe')]
    private $Membres;

    #[ORM\ManyToOne(targetEntity: Labo::class, inversedBy: 'equipes')]
    #[ORM\JoinColumn(nullable: true)]
    private $labo;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $domaine;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Specialites;

    public function __construct()
    {
        $this->Membres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getChef(): ?Professeur
    {
        return $this->chef;
    }

    public function setChef(?Professeur $chef): self
    {
        $this->chef = $chef;

        return $this;
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

    public function getLabo(): ?Labo
    {
        return $this->labo;
    }

    public function setLabo(?Labo $labo): self
    {
        $this->labo = $labo;

        return $this;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(?string $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getSpecialites(): ?string
    {
        return $this->Specialites;
    }

    public function setSpecialites(?string $Specialites): self
    {
        $this->Specialites = $Specialites;

        return $this;
    }
}
