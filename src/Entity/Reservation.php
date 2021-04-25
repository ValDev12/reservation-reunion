<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateD;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateF;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="reservations")
     */
    private $createur;

    /**
     * @ORM\ManyToMany(targetEntity=Utilisateur::class, inversedBy="reservations")
     */
    private $participant;

    /**
     * @ORM\ManyToOne(targetEntity=Salle::class, inversedBy="reservations")
     */
    private $salle;

    public function __construct()
    {
        $this->participant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateD(): ?\DateTimeInterface
    {
        return $this->dateD;
    }

    public function setDateD(\DateTimeInterface $dateD): self
    {
        $this->dateD = $dateD;

        return $this;
    }

    public function getDateF(): ?\DateTimeInterface
    {
        return $this->dateF;
    }

    public function setDateF(\DateTimeInterface $dateF): self
    {
        $this->dateF = $dateF;

        return $this;
    }

    public function getCreateur(): ?Utilisateur
    {
        return $this->createur;
    }

    public function setCreateur(?Utilisateur $createur): self
    {
        $this->createur = $createur;

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getParticipant(): Collection
    {
        return $this->participant;
    }

    public function addParticipant(Utilisateur $participant): self
    {
        if (!$this->participant->contains($participant)) {
            $this->participant[] = $participant;
        }

        return $this;
    }

    public function removeParticipant(Utilisateur $participant): self
    {
        $this->participant->removeElement($participant);

        return $this;
    }

    public function getSalle(): ?Salle
    {
        return $this->salle;
    }

    public function setSalle(?Salle $salle): self
    {
        $this->salle = $salle;

        return $this;
    }
}
