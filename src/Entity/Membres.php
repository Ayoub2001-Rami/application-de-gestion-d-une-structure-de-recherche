<?php

namespace App\Entity;

use App\Repository\MembresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: MembresRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Membres implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $prenom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Specialite;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Phone;

    #[ORM\Column(type: 'string', length: 255)]
    private $Type;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image;

    #[ORM\ManyToMany(targetEntity: ProjetRecherche::class, mappedBy: 'Membres')]
    private $projetRecherches;

    #[ORM\ManyToMany(targetEntity: Publication::class, mappedBy: 'membres')]
    private $membres;

    #[ORM\OneToMany(mappedBy: 'Auteur', targetEntity: Publication::class)]
    private $Auteur;

    #[ORM\ManyToMany(targetEntity: Equipe::class, mappedBy: 'Membres')]
    private $Mequipe;

    #[ORM\Column(type: 'text', nullable: true)]
    private $Introduction;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Etablissement;



    public function __construct()
    {
        $this->projetRecherches = new ArrayCollection();
        $this->publications = new ArrayCollection();
        $this->Auteur = new ArrayCollection();
        $this->membres = new ArrayCollection();
        $this->Mequipe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getSpecialite(): ?string
    {
        return $this->Specialite;
    }

    public function setSpecialite(?string $Specialite): self
    {
        $this->Specialite = $Specialite;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->Phone;
    }

    public function setPhone(?string $Phone): self
    {
        $this->Phone = $Phone;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): self
    {
        $this->Type = $Type;

        return $this;
    }
    public function __toString(): string
    {
        // TODO: Implement __toString() method.
        return $this->getNom()." ".$this->getPrenom();
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, ProjetRecherche>
     */
    public function getProjetRecherches(): Collection
    {
        return $this->projetRecherches;
    }

    public function addProjetRecherch(ProjetRecherche $projetRecherch): self
    {
        if (!$this->projetRecherches->contains($projetRecherch)) {
            $this->projetRecherches[] = $projetRecherch;
            $projetRecherch->addMembre($this);
        }

        return $this;
    }

    public function removeProjetRecherch(ProjetRecherche $projetRecherch): self
    {
        if ($this->projetRecherches->removeElement($projetRecherch)) {
            $projetRecherch->removeMembre($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Publication>
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Publication $membre): self
    {
        if (!$this->membres->contains($membre)) {
            $this->membres[] = $membre;
            $membre->addMembre($this);
        }

        return $this;
    }

    public function removeMembre(Publication $membre): self
    {
        if ($this->membres->removeElement($membre)) {
            $membre->removeMembre($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Publication>
     */
    public function getAuteur(): Collection
    {
        return $this->Auteur;
    }

    public function addAuteur(Publication $auteur): self
    {
        if (!$this->Auteur->contains($auteur)) {
            $this->Auteur[] = $auteur;
            $auteur->setAuteur($this);
        }

        return $this;
    }

    public function removeAuteur(Publication $auteur): self
    {
        if ($this->Auteur->removeElement($auteur)) {
            // set the owning side to null (unless already changed)
            if ($auteur->getAuteur() === $this) {
                $auteur->setAuteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Equipe>
     */
    public function getMequipe(): Collection
    {
        return $this->Mequipe;
    }

    public function addMequipe(Equipe $mequipe): self
    {
        if (!$this->Mequipe->contains($mequipe)) {
            $this->Mequipe[] = $mequipe;
            $mequipe->addMembre($this);
        }

        return $this;
    }

    public function removeMequipe(Equipe $mequipe): self
    {
        if ($this->Mequipe->removeElement($mequipe)) {
            $mequipe->removeMembre($this);
        }

        return $this;
    }

    public function getIntroduction(): ?string
    {
        return $this->Introduction;
    }

    public function setIntroduction(?string $Introduction): self
    {
        $this->Introduction = $Introduction;

        return $this;
    }

    public function getEtablissement(): ?string
    {
        return $this->Etablissement;
    }

    public function setEtablissement(?string $Etablissement): self
    {
        $this->Etablissement = $Etablissement;

        return $this;
    }


}
