<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 */
class Service
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Poste::class, mappedBy="service")
     */
    private $poste;

    /**
     * @ORM\ManyToMany(targetEntity=Salle::class, mappedBy="service")
     */
    private $salles;

    public function __construct()
    {
        $this->poste = new ArrayCollection();
        $this->salles = new ArrayCollection();
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

    /**
     * @return Collection|Poste[]
     */
    public function getPoste(): Collection
    {
        return $this->poste;
    }

    public function addPoste(Poste $poste): self
    {
        if (!$this->poste->contains($poste)) {
            $this->poste[] = $poste;
            $poste->setService($this);
        }

        return $this;
    }

    public function removePoste(Poste $poste): self
    {
        if ($this->poste->removeElement($poste)) {
            // set the owning side to null (unless already changed)
            if ($poste->getService() === $this) {
                $poste->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Salle[]
     */
    public function getSalles(): Collection
    {
        return $this->salles;
    }

    public function addSalle(Salle $salle): self
    {
        if (!$this->salles->contains($salle)) {
            $this->salles[] = $salle;
            $salle->addService($this);
        }

        return $this;
    }

    public function removeSalle(Salle $salle): self
    {
        if ($this->salles->removeElement($salle)) {
            $salle->removeService($this);
        }

        return $this;
    }
}
