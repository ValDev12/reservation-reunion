<?php

namespace App\Entity;

use App\Repository\PosteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PosteRepository::class)
 */
class Poste
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $autorisation;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="postes")
     */
    private $habilitation;

    /**
     * @ORM\OneToMany(targetEntity=Utilisateur::class, mappedBy="poste")
     */
    private $utilisateurs;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="poste")
     */
    private $service;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
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

    public function getAutorisation(): ?int
    {
        return $this->autorisation;
    }

    public function setAutorisation(int $autorisation): self
    {
        $this->autorisation = $autorisation;

        return $this;
    }

    public function getHabilitation(): ?Role
    {
        return $this->habilitation;
    }

    public function setHabilitation(?Role $habilitation): self
    {
        $this->habilitation = $habilitation;

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs[] = $utilisateur;
            $utilisateur->setPoste($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getPoste() === $this) {
                $utilisateur->setPoste(null);
            }
        }

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }
}
