<?php

namespace App\Entity;

use App\Repository\StagiaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StagiaireRepository::class)]
class Stagiaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(targetEntity: Membres::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $id_membre;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $prenom;

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
}
