<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PromotionRepository::class)
 */
class Promotion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="promotion")
     */
    private $groupe_promo;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="promotions")
     */
    private $formateur_promo;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, mappedBy="promo_referentiel")
     */
    private $referentiels;

    public function __construct()
    {
        $this->groupe_promo = new ArrayCollection();
        $this->formateur_promo = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupePromo(): Collection
    {
        return $this->groupe_promo;
    }

    public function addGroupePromo(Groupe $groupePromo): self
    {
        if (!$this->groupe_promo->contains($groupePromo)) {
            $this->groupe_promo[] = $groupePromo;
            $groupePromo->setPromotion($this);
        }

        return $this;
    }

    public function removeGroupePromo(Groupe $groupePromo): self
    {
        if ($this->groupe_promo->contains($groupePromo)) {
            $this->groupe_promo->removeElement($groupePromo);
            // set the owning side to null (unless already changed)
            if ($groupePromo->getPromotion() === $this) {
                $groupePromo->setPromotion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Formateur[]
     */
    public function getFormateurPromo(): Collection
    {
        return $this->formateur_promo;
    }

    public function addFormateurPromo(Formateur $formateurPromo): self
    {
        if (!$this->formateur_promo->contains($formateurPromo)) {
            $this->formateur_promo[] = $formateurPromo;
        }

        return $this;
    }

    public function removeFormateurPromo(Formateur $formateurPromo): self
    {
        if ($this->formateur_promo->contains($formateurPromo)) {
            $this->formateur_promo->removeElement($formateurPromo);
        }

        return $this;
    }

    /**
     * @return Collection|Referentiel[]
     */
    public function getReferentiels(): Collection
    {
        return $this->referentiels;
    }

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiels->contains($referentiel)) {
            $this->referentiels[] = $referentiel;
            $referentiel->addPromoReferentiel($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiels->contains($referentiel)) {
            $this->referentiels->removeElement($referentiel);
            $referentiel->removePromoReferentiel($this);
        }

        return $this;
    }
}
