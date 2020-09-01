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
 * @ApiResource(
 *       collectionOperations={
*          "get_un"={
*               "method"="GET",
*                   "path"="formateurs/promo/{id}/referentiel/{id_a}/competences",
*                   "route_name"="get_un",
*          },
*           
*          "get_deux"={
*               "method"="GET",
*                   "path"="formateurs/promo/{id}/referentiel/{id_b}/statistiques/competences",
*                   "route_name"="get_deux",
*                   
*          },
*
*          "get_deux_deux"={
*               "method"="GET",
*                   "path"="apprenants/{id}/promo/{idc}/referentiel/{ide}/statistiques/briefs",
*                   "route_name"="get_deux_deux",
*          },
*           "get_formateur_com"={
*              "method"="GET",
*              "path"="formateurs/livrablepartiels/{id}/commentaires",
*              "route_name"="get_formateur_com",
*          },
*           "post_formateur"={
*              "method"="POST",
*              "path"="formateurs/livrablepartiels/{id}/commentaires",
*              "route_name"="post_formateur",
*          }
* },
*        itemOperations={
*
*           "get_un_it"={
*               "method"="GET",
*                   "path"="formateurs/promo/{id}/brief/{id_c}/livrablepartiels",
*                   "normalization_context"={"groups"={"trois:read"}},
*                   "security"="is_granted('ROLE_APPRENANT')||is_granted('ROLE_FORMATEUR')",
*                   "security_message"="Vous n'avez pas access à cette Ressource"
*          },
*          "get_deux_it"={
*               "method"="PUT",
*                   "path"="apprenants/{id}/livrablepartiels/{id_d}",
*                   "route_name"="get_deux_it",
*          },
*            "put_deux_it"={
*               "method"="PUT",
*                   "path"="formateurs/promo/{idp}/brief/{idb}/livrablepartiels",
*                   "route_name"="put_deux_it",
*          }
*}
 *
 * )
 */
class LivrablePartiel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"quatre:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"quatre:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="datetime")
     */
    private $delai;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbreRendu;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbreCorrige;

    /**
     * @ORM\ManyToMany(targetEntity=Niveau::class, inversedBy="livrablePartiels", cascade={"persist"})
     * @Groups({"un:read"})
     */
    private $niveau;

   
    /**
     * @ORM\ManyToOne(targetEntity=BriefMaPromo::class, inversedBy="livrablePartiels")
     */
    private $briefmapromo;

    /**
     * @ORM\OneToMany(targetEntity=ApprenantLivrablePartiel::class, mappedBy="livrablePartiel")
     * @Groups({"commentaires"})
     */
    private $apprenantlivrablepartiel;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted;

   

   

    public function __construct()
    {
        $this->niveau = new ArrayCollection();
        $this->apprenantlivrablepartiel = new ArrayCollection();
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

  

    public function getBriefmapromo(): ?BriefMaPromo
    {
        return $this->briefmapromo;
    }

    public function setBriefmapromo(?BriefMaPromo $briefmapromo): self
    {
        $this->briefmapromo = $briefmapromo;

        return $this;
    }

    /**
     * @return Collection|ApprenantLivrablePartiel[]
     */
    public function getApprenantlivrablepartiel(): Collection
    {
        return $this->apprenantlivrablepartiel;
    }

    public function addApprenantlivrablepartiel(ApprenantLivrablePartiel $apprenantlivrablepartiel): self
    {
        if (!$this->apprenantlivrablepartiel->contains($apprenantlivrablepartiel)) {
            $this->apprenantlivrablepartiel[] = $apprenantlivrablepartiel;
            $apprenantlivrablepartiel->setLivrablePartiel($this);
        }

        return $this;
    }

    public function removeApprenantlivrablepartiel(ApprenantLivrablePartiel $apprenantlivrablepartiel): self
    {
        if ($this->apprenantlivrablepartiel->contains($apprenantlivrablepartiel)) {
            $this->apprenantlivrablepartiel->removeElement($apprenantlivrablepartiel);
            // set the owning side to null (unless already changed)
            if ($apprenantlivrablepartiel->getLivrablePartiel() === $this) {
                $apprenantlivrablepartiel->setLivrablePartiel(null);
            }
        }

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

   

   
}
