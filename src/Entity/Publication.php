<?php

namespace App\Entity;

use App\Repository\PublicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PublicationRepository::class)]
class Publication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'date')]
    private $annee;

    #[ORM\Column(type: 'string', length: 255)]
    private $lien;

    #[ORM\Column(type: 'text', nullable: true)]
    private $text;

    #[ORM\ManyToMany(targetEntity: Membres::class, inversedBy: 'membres')]
    private $membres;

    #[ORM\ManyToOne(targetEntity: Membres::class, inversedBy: 'Auteur')]
    private $Auteur;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Autre;


    public function __construct()
    {
        $this->membre = new ArrayCollection();
        $this->membres = new ArrayCollection();
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

    public function getAnnee(): ?\DateTimeInterface
    {
        return $this->annee;
    }

    public function setAnnee(\DateTimeInterface $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection<int, Membres>
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Membres $membre): self
    {
        if (!$this->membres->contains($membre)) {
            $this->membres[] = $membre;
        }

        return $this;
    }

    public function removeMembre(Membres $membre): self
    {
        $this->membres->removeElement($membre);

        return $this;
    }

    public function getAuteur(): ?Membres
    {
        return $this->Auteur;
    }

    public function setAuteur(?Membres $Auteur): self
    {
        $this->Auteur = $Auteur;

        return $this;
    }

    public function getAutre(): ?string
    {
        return $this->Autre;
    }

    public function setAutre(?string $Autre): self
    {
        $this->Autre = $Autre;

        return $this;
    }


}
