<?php

namespace App\Entity;

use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 */
class Groupe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="groupe")
     */
    private $groupe_apprenant;

    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="groupes")
     */
    private $groupe_formateur;

    /**
     * @ORM\ManyToOne(targetEntity=Promotion::class, inversedBy="groupe_promo")
     */
    private $promotion;

    public function __construct()
    {
        $this->groupe_apprenant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getGroupeApprenant(): Collection
    {
        return $this->groupe_apprenant;
    }

    public function addGroupeApprenant(Apprenant $groupeApprenant): self
    {
        if (!$this->groupe_apprenant->contains($groupeApprenant)) {
            $this->groupe_apprenant[] = $groupeApprenant;
            $groupeApprenant->setGroupe($this);
        }

        return $this;
    }

    public function removeGroupeApprenant(Apprenant $groupeApprenant): self
    {
        if ($this->groupe_apprenant->contains($groupeApprenant)) {
            $this->groupe_apprenant->removeElement($groupeApprenant);
            // set the owning side to null (unless already changed)
            if ($groupeApprenant->getGroupe() === $this) {
                $groupeApprenant->setGroupe(null);
            }
        }

        return $this;
    }

    public function getGroupeFormateur(): ?Formateur
    {
        return $this->groupe_formateur;
    }

    public function setGroupeFormateur(?Formateur $groupe_formateur): self
    {
        $this->groupe_formateur = $groupe_formateur;

        return $this;
    }

    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }

    public function setPromotion(?Promotion $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }
}
