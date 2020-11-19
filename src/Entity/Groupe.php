<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\Collection;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"prom_ref_app_form"}},
 *      attributes={
 *          "security"="is_granted('ROLE_ADMIN') || is_granted('ROLE_FORMATEUR')",
 *          "security_message"="Vous n'avez pas access à cette Ressource"
 *      },
 *      collectionOperations={
 *          "promo_ref_apprenant_formateur"={
 *              "method"="GET", 
 *              "path"="/admin/groupes"
 *          },
 *          "crew_get"={
 *              "method"="GET", 
 *              "path"="admin/groupes/apprenants"
 *          },
 *          "crew_post"={
 *              "method"="POST", 
 *              "path"="/admin/groupes",
 *              "defaults"={"id"=null}
 *          }
 *      },
 *      itemOperations={
 *          "crew_item"={
 *              "method"="GET", 
 *              "path"="/admin/groupes/{id}"
 *          },
 *          "criw_item"={
 *              "method"="PUT", 
 *              "path"="/admin/groupes/{id}"
 *          },
 *          "criw_del"={
 *              "method"="DELETE", 
 *              "path"="/admin/groupes/{id}/apprenants"
 *          },
 *          "get_crew_student"={
 *              "method"="GET", 
 *              "path"="/admin/groupes/{id}/apprenants"
 *          }
 * 
 *      }
 *)
 */
class Groupe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
<<<<<<< HEAD
     * @Groups({"brief_assigned","brief_gpe_promo","brief_of_promo","brief_of_one_promo","prom_ref_app_form", "referentiel_formateur_gpe:read","statut_groupe:read"})
=======
     * @Groups({"prom_ref_app_form", "referentiel_formateur_gpe:read","statut_groupe:read"})
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
<<<<<<< HEAD
     * @Groups({"brief_assigned","brief_gpe_promo","brief_of_promo","brief_of_one_promo","prom_ref_app_form", "referentiel_formateur_gpe:read","apprenant_id_promo:read","statut_groupe:read"})
=======
     * @Groups({"prom_ref_app_form", "referentiel_formateur_gpe:read","apprenant_id_promo:read","statut_groupe:read"})
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
     */
    private $nomGroupe;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, inversedBy="groupes", cascade={"persist"})
<<<<<<< HEAD
     * @Groups({"brief_assigned","prom_ref_app_form","apprenant_id_promo:read","brief_of_promo","brief_of_one_promo"})
=======
     * @Groups({"prom_ref_app_form","apprenant_id_promo:read"})
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
     */
    private $apprenant;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, mappedBy="groupe", cascade={"persist"})
     * @Groups({"prom_ref_app_form"})
     */
    private $formateurs;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="groupe",cascade={"persist"})
<<<<<<< HEAD
     * @Groups({"prom_ref_app_form","brief_of_promo"})
=======
     * @Groups({"prom_ref_app_form"})
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
     */
    private $promo;

    /**
     * @ORM\OneToMany(targetEntity=EtatBriefGroupe::class, mappedBy="groupe")
     */
    private $etatbriefgroupe;

    public function __construct()
    {
        $this->apprenant = new ArrayCollection();
        $this->formateurs = new ArrayCollection();
        $this->etatbriefgroupe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomGroupe(): ?string
    {
        return $this->nomGroupe;
    }

    public function setNomGroupe(string $nomGroupe): self
    {
        $this->nomGroupe = $nomGroupe;

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenant(): Collection
    {
        return $this->apprenant;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenant->contains($apprenant)) {
            $this->apprenant[] = $apprenant;
            $apprenant->addGroupe($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenant->contains($apprenant)) {
            $this->apprenant->removeElement($apprenant);
            $apprenant->removeGroupe($this);
        }

        return $this;
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
            $formateur->addGroupe($this);
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        if ($this->formateurs->contains($formateur)) {
            $this->formateurs->removeElement($formateur);
            $formateur->removeGroupe($this);
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
     * @return Collection|EtatBriefGroupe[]
     */
    public function getEtatbriefgroupe(): Collection
    {
        return $this->etatbriefgroupe;
    }

    public function addEtatbriefgroupe(EtatBriefGroupe $etatbriefgroupe): self
    {
        if (!$this->etatbriefgroupe->contains($etatbriefgroupe)) {
            $this->etatbriefgroupe[] = $etatbriefgroupe;
            $etatbriefgroupe->setGroupe($this);
        }

        return $this;
    }

    public function removeEtatbriefgroupe(EtatBriefGroupe $etatbriefgroupe): self
    {
        if ($this->etatbriefgroupe->contains($etatbriefgroupe)) {
            $this->etatbriefgroupe->removeElement($etatbriefgroupe);
            // set the owning side to null (unless already changed)
            if ($etatbriefgroupe->getGroupe() === $this) {
                $etatbriefgroupe->setGroupe(null);
            }
        }

        return $this;
    }
}
