<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CandidatureRepository::class)
 */
class Candidature
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
    private $valider;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="candidatures")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Offre::class, inversedBy="candidature")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_offre;

    /**
     * @ORM\OneToOne(targetEntity=RendezVous::class, mappedBy="candidature", cascade={"persist", "remove"})
     */
    private $rendezVous;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getValider(): ?string
    {
        return $this->valider;
    }

    public function setValider(string $valider): self
    {
        $this->valider = $valider;

        return $this;
    }

    public function getIdOffre(): ?Offre
    {
        return $this->id_offre;
    }

    public function setIdOffre(?Offre $id_offre): self
    {
        $this->id_offre = $id_offre;

        return $this;
    }

    public function getRendezVous(): ?RendezVous
    {
        return $this->rendezVous;
    }

    public function setRendezVous(RendezVous $rendezVous): self
    {
        // set the owning side of the relation if necessary
        if ($rendezVous->getCandidature() !== $this) {
            $rendezVous->setCandidature($this);
        }

        $this->rendezVous = $rendezVous;

        return $this;
    }

}
