<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffreRepository::class)
 */
class Offre
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
    private $Contenu;


    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $Date_C;

    /**
     * @ORM\OneToMany(targetEntity=Candidature::class, mappedBy="id_offre")
     */
    private $candidature;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="offre")
     */
    private $categorie;

    public function __construct()
    {
        $this->candidature = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->Contenu;
    }

    public function setContenu(string $Contenu): self
    {
        $this->Contenu = $Contenu;

        return $this;
    }


    public function getDateC(): ?\DateTimeInterface
    {
        return $this->Date_C;
    }

    public function setDateC(?\DateTimeInterface $Date_C): self
    {
        $this->Date_C = $Date_C;

        return $this;
    }

    /**
     * @return Collection|Candidature[]
     */
    public function getCandidature(): Collection
    {
        return $this->candidature;
    }

    public function addCandidature(Candidature $candidature): self
    {
        if (!$this->candidature->contains($candidature)) {
            $this->candidature[] = $candidature;
            $candidature->setIdOffre($this);
        }

        return $this;
    }

    public function removeCandidature(Candidature $candidature): self
    {
        if ($this->candidature->removeElement($candidature)) {
            // set the owning side to null (unless already changed)
            if ($candidature->getIdOffre() === $this) {
                $candidature->setIdOffre(null);
            }
        }

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
