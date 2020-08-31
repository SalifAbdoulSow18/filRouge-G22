<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivrablePartielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=LivrablePartielRepository::class)
 */
class LivrablePartiel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"brief_of_promo","brief_of_one_promo"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"brief_of_promo","brief_of_one_promo"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"brief_of_promo","brief_of_one_promo"})
     */
    private $delai;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"brief_of_promo","brief_of_one_promo"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"brief_of_promo","brief_of_one_promo"})
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"brief_of_promo","brief_of_one_promo"})
     */
    private $nbreRendu;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"brief_of_promo","brief_of_one_promo"})
     */
    private $nbreCorrige;

    /**
     * @ORM\ManyToMany(targetEntity=Niveau::class, inversedBy="livrablePartiels")
     */
    private $niveau;

    /**
     * @ORM\OneToMany(targetEntity=ApprenantLivrablePartiel::class, mappedBy="livrablePartiels")
     */
    private $apprenantlivrablepartiel;

    /**
     * @ORM\ManyToOne(targetEntity=BriefMaPromo::class, inversedBy="livrablePartiels")
     */
    private $briefmapromo;

    public function __construct()
    {
        $this->niveau = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDelai(): ?\DateTimeInterface
    {
        return $this->delai;
    }

    public function setDelai(\DateTimeInterface $delai): self
    {
        $this->delai = $delai;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNbreRendu(): ?int
    {
        return $this->nbreRendu;
    }

    public function setNbreRendu(int $nbreRendu): self
    {
        $this->nbreRendu = $nbreRendu;

        return $this;
    }

    public function getNbreCorrige(): ?int
    {
        return $this->nbreCorrige;
    }

    public function setNbreCorrige(int $nbreCorrige): self
    {
        $this->nbreCorrige = $nbreCorrige;

        return $this;
    }

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveau(): Collection
    {
        return $this->niveau;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveau->contains($niveau)) {
            $this->niveau[] = $niveau;
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveau->contains($niveau)) {
            $this->niveau->removeElement($niveau);
        }

        return $this;
    }

    public function getApprenantlivrablepartiel(): ?ApprenantLivrablePartiel
    {
        return $this->apprenantlivrablepartiel;
    }

    public function setApprenantlivrablepartiel(?ApprenantLivrablePartiel $apprenantlivrablepartiel): self
    {
        $this->apprenantlivrablepartiel = $apprenantlivrablepartiel;

        return $this;
    }

    public function getBriefmapromo(): ?BriefMaPromo
    {
        return $this->briefmapromo;
    }

    public function setBriefmapromo(?BriefMaPromo $briefmapromo): self
    {
        $this->briefmapromo = $briefmapromo;

        return $this;
    }
}
