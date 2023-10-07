<?php

namespace App\Entity;

use App\Repository\LaboRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LaboRepository::class)]
class Labo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\OneToOne(targetEntity: Professeur::class, cascade: ['persist', 'remove'])]
    private $chef;

    #[ORM\Column(type: 'text', nullable: true)]
    private $domaindeRecherche;

    #[ORM\OneToMany(mappedBy: 'labo', targetEntity: Equipe::class)]
    private $equipes;

    public function __construct()
    {
        $this->equipes = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getDomaindeRecherche(): ?string
    {
        return $this->domaindeRecherche;
    }

    public function setDomaindeRecherche(?string $domaindeRecherche): self
    {
        $this->domaindeRecherche = $domaindeRecherche;

        return $this;
    }
    public function __toString(): string
    {
        // TODO: Implement __toString() method.
        return $this->getNom();
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
            $equipe->setLabo($this);
        }

        return $this;
    }

    public function removeEquipe(Equipe $equipe): self
    {
        if ($this->equipes->removeElement($equipe)) {
            // set the owning side to null (unless already changed)
            if ($equipe->getLabo() === $this) {
                $equipe->setLabo(null);
            }
        }

        return $this;
    }
}
