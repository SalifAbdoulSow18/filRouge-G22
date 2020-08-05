<?php

namespace App\Entity;

use App\Repository\ReferentielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReferentielRepository::class)
 */
class Referentiel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, inversedBy="referentiels")
     */
    private $promo;

    /**
     * @ORM\ManyToMany(targetEntity=GrpeCompetence::class, inversedBy="referentiels")
     */
    private $grpeCompetence;

    public function __construct()
    {
        $this->promo = new ArrayCollection();
        $this->grpeCompetence = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Promo[]
     */
    public function getPromo(): Collection
    {
        return $this->promo;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promo->contains($promo)) {
            $this->promo[] = $promo;
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promo->contains($promo)) {
            $this->promo->removeElement($promo);
        }

        return $this;
    }

    /**
     * @return Collection|GrpeCompetence[]
     */
    public function getGrpeCompetence(): Collection
    {
        return $this->grpeCompetence;
    }

    public function addGrpeCompetence(GrpeCompetence $grpeCompetence): self
    {
        if (!$this->grpeCompetence->contains($grpeCompetence)) {
            $this->grpeCompetence[] = $grpeCompetence;
        }

        return $this;
    }

    public function removeGrpeCompetence(GrpeCompetence $grpeCompetence): self
    {
        if ($this->grpeCompetence->contains($grpeCompetence)) {
            $this->grpeCompetence->removeElement($grpeCompetence);
        }

        return $this;
    }
}
