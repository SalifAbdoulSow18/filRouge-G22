<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BriefMaPromoRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BriefMaPromoRepository::class)
 */
class BriefMaPromo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Brief::class, inversedBy="briefmapromo")
     */
    private $brief;

    /**
     * @ORM\OneToMany(targetEntity=LivrablePartiel::class, mappedBy="briefmapromo")
     * @Groups({"brief_of_promo","brief_of_one_promo"})
     */
    private $livrablePartiels;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="briefmapromo")
     * @Groups({"brief_assigned","brief_gpe_promo","brief_of_one_promo"})
     */
    private $promo;

    /**
     * @ORM\OneToMany(targetEntity=BriefApprenant::class, mappedBy="briefMaPromo")
     */
    private $briefapprenant;

    public function __construct()
    {
        $this->livrablePartiels = new ArrayCollection();
        $this->briefapprenant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrief(): ?Brief
    {
        return $this->brief;
    }

    public function setBrief(?Brief $brief): self
    {
        $this->brief = $brief;

        return $this;
    }

    /**
     * @return Collection|LivrablePartiel[]
     */
    public function getLivrablePartiels(): Collection
    {
        return $this->livrablePartiels;
    }

    public function addLivrablePartiel(LivrablePartiel $livrablePartiel): self
    {
        if (!$this->livrablePartiels->contains($livrablePartiel)) {
            $this->livrablePartiels[] = $livrablePartiel;
            $livrablePartiel->setBriefmapromo($this);
        }

        return $this;
    }

    public function removeLivrablePartiel(LivrablePartiel $livrablePartiel): self
    {
        if ($this->livrablePartiels->contains($livrablePartiel)) {
            $this->livrablePartiels->removeElement($livrablePartiel);
            // set the owning side to null (unless already changed)
            if ($livrablePartiel->getBriefmapromo() === $this) {
                $livrablePartiel->setBriefmapromo(null);
            }
        }

        return $this;
    }

    public function getPromo(): ?Promo
    {
        return $this->promo;
    }

    public function setPromo(?Promo $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * @return Collection|BriefApprenant[]
     */
    public function getBriefapprenant(): Collection
    {
        return $this->briefapprenant;
    }

    public function addBriefapprenant(BriefApprenant $briefapprenant): self
    {
        if (!$this->briefapprenant->contains($briefapprenant)) {
            $this->briefapprenant[] = $briefapprenant;
            $briefapprenant->setBriefMaPromo($this);
        }

        return $this;
    }

    public function removeBriefapprenant(BriefApprenant $briefapprenant): self
    {
        if ($this->briefapprenant->contains($briefapprenant)) {
            $this->briefapprenant->removeElement($briefapprenant);
            // set the owning side to null (unless already changed)
            if ($briefapprenant->getBriefMaPromo() === $this) {
                $briefapprenant->setBriefMaPromo(null);
            }
        }

        return $this;
    }
}
