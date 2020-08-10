<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PromoRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PromoRepository::class)
 * @ApiResource(   
 *      attributes={
 *          "security"="is_granted('ROLE_ADMIN') || is_granted('ROLE_FORMATEUR') || is_granted('ROLE_CM')",
 *          "security_message"="Vous n'avez pas access à cette Ressource"
 *          },
 *      collectionOperations={
 *          "ref_form_gpe"={
 *              "path"="/admin/promo",
 *              "normalization_context"={"groups"={"reforgpe"}},
 *              "method"="GET"
 *          },
 *          "post"={
 *              "path"="/admin/promo",
 *              "security"="is_granted('ROLE_ADMIN') || is_granted('ROLE_FORMATEUR')",
 *              "security_message"="Vous n'avez pas access à cette Ressource"
 *          }
 *      },
 *      itemOperations={
 *          "ref_form_gpe_id"={
 *              "path"="/admin/promo/{id}/referentiels",
 *              "normalization_context"={"groups"={"reprogpecompcomp"}},
 *              "method"="GET"
 *          },
 *          "ref_prom_gpecom_comp_id"={
 *              "path"="/admin/promo/{id}",
 *              "normalization_context"={"groups"={"reforgpe"}},
 *              "method"="GET"
 *          },
 *          "put"={
 *              "path"="/admin/promo/{id}",
 *              "security"="is_granted('ROLE_ADMIN') || is_granted('ROLE_FORMATEUR')",
 *              "security_message"="Vous n'avez pas access à cette Ressource"
 *          },
 *      }
 * )
 */
class Promo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"reprogpecompcomp"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="date")
     * @Groups({"reprogpecompcomp"})
     */
    private $annee;

    /**
     * @ORM\Column(type="date")
     * @Groups({"reprogpecompcomp"})
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     * @Groups({"reprogpecompcomp"})
     */
    private $dateFin;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, mappedBy="promo")
     * @Groups({"reforgpe"})
     */
    private $formateurs;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="promo")
     * @Groups({"reforgpe"})
     */
    private $groupe;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, mappedBy="promo")
     * @Groups({"reforgpe","reprogpecompcomp"})
     */
    private $referentiels;

    public function __construct()
    {
        $this->formateurs = new ArrayCollection();
        $this->groupe = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Formateur[]
     */
    public function getFormateurs(): Collection
    {
        return $this->formateurs;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->formateurs->contains($formateur)) {
            $this->formateurs[] = $formateur;
            $formateur->addPromo($this);
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        if ($this->formateurs->contains($formateur)) {
            $this->formateurs->removeElement($formateur);
            $formateur->removePromo($this);
        }

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupe(): Collection
    {
        return $this->groupe;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupe->contains($groupe)) {
            $this->groupe[] = $groupe;
            $groupe->setPromo($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupe->contains($groupe)) {
            $this->groupe->removeElement($groupe);
            // set the owning side to null (unless already changed)
            if ($groupe->getPromo() === $this) {
                $groupe->setPromo(null);
            }
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
            $referentiel->addPromo($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiels->contains($referentiel)) {
            $this->referentiels->removeElement($referentiel);
            $referentiel->removePromo($this);
        }

        return $this;
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

    public function getAnnee(): ?\DateTimeInterface
    {
        return $this->annee;
    }

    public function setAnnee(\DateTimeInterface $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }
}
