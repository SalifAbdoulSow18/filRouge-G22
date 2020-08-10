<?php

namespace App\Entity;

use App\Repository\NiveauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NiveauRepository::class)
 */
class Niveau
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Niveau::class, inversedBy="niveaux")
     */
    private $competence_niveau;

    /**
     * @ORM\ManyToMany(targetEntity=Niveau::class, mappedBy="competence_niveau")
     */
    private $niveaux;

    public function __construct()
    {
        $this->competence_niveau = new ArrayCollection();
        $this->niveaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|self[]
     */
    public function getCompetenceNiveau(): Collection
    {
        return $this->competence_niveau;
    }

    public function addCompetenceNiveau(self $competenceNiveau): self
    {
        if (!$this->competence_niveau->contains($competenceNiveau)) {
            $this->competence_niveau[] = $competenceNiveau;
        }

        return $this;
    }

    public function removeCompetenceNiveau(self $competenceNiveau): self
    {
        if ($this->competence_niveau->contains($competenceNiveau)) {
            $this->competence_niveau->removeElement($competenceNiveau);
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(self $niveau): self
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux[] = $niveau;
            $niveau->addCompetenceNiveau($this);
        }

        return $this;
    }

    public function removeNiveau(self $niveau): self
    {
        if ($this->niveaux->contains($niveau)) {
            $this->niveaux->removeElement($niveau);
            $niveau->removeCompetenceNiveau($this);
        }

        return $this;
    }
}
