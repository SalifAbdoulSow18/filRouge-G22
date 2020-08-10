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
     * @ORM\ManyToMany(targetEntity=Promotion::class, inversedBy="referentiels")
     */
    private $promo_referentiel;

    /**
     * @ORM\ManyToMany(targetEntity=GpeCompetence::class, inversedBy="referentiels")
     */
    private $grpeCompetence_referentiel;

    public function __construct()
    {
        $this->promo_referentiel = new ArrayCollection();
        $this->grpeCompetence_referentiel = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Promotion[]
     */
    public function getPromoReferentiel(): Collection
    {
        return $this->promo_referentiel;
    }

    public function addPromoReferentiel(Promotion $promoReferentiel): self
    {
        if (!$this->promo_referentiel->contains($promoReferentiel)) {
            $this->promo_referentiel[] = $promoReferentiel;
        }

        return $this;
    }

    public function removePromoReferentiel(Promotion $promoReferentiel): self
    {
        if ($this->promo_referentiel->contains($promoReferentiel)) {
            $this->promo_referentiel->removeElement($promoReferentiel);
        }

        return $this;
    }

    /**
     * @return Collection|GpeCompetence[]
     */
    public function getGrpeCompetenceReferentiel(): Collection
    {
        return $this->grpeCompetence_referentiel;
    }

    public function addGrpeCompetenceReferentiel(GpeCompetence $grpeCompetenceReferentiel): self
    {
        if (!$this->grpeCompetence_referentiel->contains($grpeCompetenceReferentiel)) {
            $this->grpeCompetence_referentiel[] = $grpeCompetenceReferentiel;
        }

        return $this;
    }

    public function removeGrpeCompetenceReferentiel(GpeCompetence $grpeCompetenceReferentiel): self
    {
        if ($this->grpeCompetence_referentiel->contains($grpeCompetenceReferentiel)) {
            $this->grpeCompetence_referentiel->removeElement($grpeCompetenceReferentiel);
        }

        return $this;
    }
}
