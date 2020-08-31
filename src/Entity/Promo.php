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
<<<<<<< HEAD
 *          "referentiel_formateur_gpe"={
 *              "path"="/admin/promo",
 *              "normalization_context"={"groups"={"referentiel_formateur_gpe:read"}},
=======
 *          "ref_form_gpe"={
 *              "path"="/admin/promo",
 *              "normalization_context"={"groups"={"reforgpe"}},
>>>>>>> 7e9215b8b667b706bac8381ff69638309b539849
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
<<<<<<< HEAD
 *              "normalization_context"={"groups"={"promo_ref_gpecomp_competence:read"}},
=======
 *              "normalization_context"={"groups"={"reprogpecompcomp"}},
>>>>>>> 7e9215b8b667b706bac8381ff69638309b539849
 *              "method"="GET"
 *          },
 *          "ref_prom_gpecom_comp_id"={
 *              "path"="/admin/promo/{id}",
<<<<<<< HEAD
 *              "normalization_context"={"groups"={"referentiel_formateur_gpe:read"}},
 *              "method"="GET"
 *          },
 *          "formateur_groupe_referentiel_of_one_promo"={
 *              "path"="/admin/promo/{id}/formateurs",
 *              "normalization_context"={"groups"={"referentiel_formateur_gpe:read"}},
 *              "method"="GET"
 *          },
 *          "statut_groupe"={
 *              "path"="/admin/promo/{id}/groupes/{id1}",
 *              "normalization_context"={"groups"={"statut_groupe:read"}},
 *              "method"="PUT"
 *          },
 *          "promo_id_apprenant"={
 *              "path"="/admin/promo/{id}/apprenants",
 *              "normalization_context"={"groups"={"promo_id_apprenant:read"}},
 *              "method"="PUT"
 *          },
 *          "put_ref_promo"={
 *              "method"="PUT",
 *              "path"="/admin/promo/{id}",              
 *              "normalization_context"={"groups"={"put_ref_promo:read"}},
 *              "security"="is_granted('ROLE_ADMIN') || is_granted('ROLE_FORMATEUR')",
 *              "security_message"="Vous n'avez pas access à cette Ressource"
 *          },
 *           "apprenant_id_promo"={
 *              "path"="/admin/promo/{id1}/groupes/{id}/apprenants",
 *              "normalization_context"={"groups"={"apprenant_id_promo:read"}},
 *              "method"="GET"
 *          },
=======
 *              "normalization_context"={"groups"={"reforgpe"}},
 *              "method"="GET"
 *          },
 *          "put"={
 *              "path"="/admin/promo/{id}",
 *              "security"="is_granted('ROLE_ADMIN') || is_granted('ROLE_FORMATEUR')",
 *              "security_message"="Vous n'avez pas access à cette Ressource"
 *          },
>>>>>>> 7e9215b8b667b706bac8381ff69638309b539849
 *      }
 * )
 */
class Promo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"promo_ref_gpecomp_competence:read","prom_ref_app_form","put_ref_promo:read","apprenant_profilsortie_promo"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
<<<<<<< HEAD
     * @Groups({"prom_ref_app_form", "referentiel_formateur_gpe:read","promo_ref_gpecomp_competence:read","apprenant_id_promo:read","put_ref_promo:read","statut_groupe:read","apprenant_profilsortie_promo"}) 
=======
     * @Groups({"reprogpecompcomp"})
>>>>>>> 7e9215b8b667b706bac8381ff69638309b539849
     */
    private $libelle;

    /**
     * @ORM\Column(type="date")
<<<<<<< HEAD
     * @Groups({"prom_ref_app_form","referentiel_formateur_gpe:read","promo_ref_gpecomp_competence:read","apprenant_id_promo:read","apprenant_profilsortie_promo"})
=======
     * @Groups({"reprogpecompcomp"})
>>>>>>> 7e9215b8b667b706bac8381ff69638309b539849
     */
    private $annee;

    /**
     * @ORM\Column(type="date")
<<<<<<< HEAD
     * @Groups({"referentiel_formateur_gpe:read","promo_ref_gpecomp_competence:read"})
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     * @Groups({"referentiel_formateur_gpe:read","promo_ref_gpecomp_competence:read",})
     */
    private $dateFin;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, mappedBy="promo", cascade={"persist"})
     * @Groups({"referentiel_formateur_gpe:read"})
=======
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
>>>>>>> 7e9215b8b667b706bac8381ff69638309b539849
     */
    private $formateurs;

    /**
<<<<<<< HEAD
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="promo",cascade={"persist"})
     * @Groups({"referentiel_formateur_gpe:read","apprenant_id_promo:read"})
=======
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="promo")
     * @Groups({"reforgpe"})
>>>>>>> 7e9215b8b667b706bac8381ff69638309b539849
     */
    private $groupe;

    /**
<<<<<<< HEAD
     * @ORM\ManyToMany(targetEntity=Referentiel::class, mappedBy="promo", cascade={"persist"})
     * @Groups({"referentiel_formateur_gpe:read","prom_ref_app_form","promo_ref_gpecomp_competence:read","apprenant_id_promo:read","put_ref_promo:read","statut_groupe:read"})
=======
     * @ORM\ManyToMany(targetEntity=Referentiel::class, mappedBy="promo")
     * @Groups({"reforgpe","reprogpecompcomp"})
>>>>>>> 7e9215b8b667b706bac8381ff69638309b539849
     */
    private $referentiels;

    /**
     * @ORM\OneToMany(targetEntity=CompetencesValides::class, mappedBy="promo")
     */
    private $competencesValides;

    /**
     * @ORM\ManyToOne(targetEntity=Referentiel::class, inversedBy="promos")
     */
    private $referentiel;

    /**
     * @ORM\OneToMany(targetEntity=Chat::class, mappedBy="promo")
     */
    private $chat;

    /**
     * @ORM\OneToMany(targetEntity=BriefMaPromo::class, mappedBy="promo")
     */
    private $briefmapromo;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="promo")
     */
    private $apprenants;

    public function __construct()
    {
        $this->formateurs = new ArrayCollection();
        $this->groupe = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
        $this->competencesValides = new ArrayCollection();
        $this->chat = new ArrayCollection();
        $this->briefmapromo = new ArrayCollection();
        $this->apprenants = new ArrayCollection();
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
<<<<<<< HEAD

    /**
     * @return Collection|CompetencesValides[]
     */
    public function getCompetencesValides(): Collection
    {
        return $this->competencesValides;
    }

    public function addCompetencesValide(CompetencesValides $competencesValide): self
    {
        if (!$this->competencesValides->contains($competencesValide)) {
            $this->competencesValides[] = $competencesValide;
            $competencesValide->setPromo($this);
        }

        return $this;
    }

    public function removeCompetencesValide(CompetencesValides $competencesValide): self
    {
        if ($this->competencesValides->contains($competencesValide)) {
            $this->competencesValides->removeElement($competencesValide);
            // set the owning side to null (unless already changed)
            if ($competencesValide->getPromo() === $this) {
                $competencesValide->setPromo(null);
            }
        }

        return $this;
    }

    public function getReferentiel(): ?Referentiel
    {
        return $this->referentiel;
    }

    public function setReferentiel(?Referentiel $referentiel): self
    {
        $this->referentiel = $referentiel;

        return $this;
    }

    /**
     * @return Collection|Chat[]
     */
    public function getChat(): Collection
    {
        return $this->chat;
    }

    public function addChat(Chat $chat): self
    {
        if (!$this->chat->contains($chat)) {
            $this->chat[] = $chat;
            $chat->setPromo($this);
        }

        return $this;
    }

    public function removeChat(Chat $chat): self
    {
        if ($this->chat->contains($chat)) {
            $this->chat->removeElement($chat);
            // set the owning side to null (unless already changed)
            if ($chat->getPromo() === $this) {
                $chat->setPromo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BriefMaPromo[]
     */
    public function getBriefmapromo(): Collection
    {
        return $this->briefmapromo;
    }

    public function addBriefmapromo(BriefMaPromo $briefmapromo): self
    {
        if (!$this->briefmapromo->contains($briefmapromo)) {
            $this->briefmapromo[] = $briefmapromo;
            $briefmapromo->setPromo($this);
        }

        return $this;
    }

    public function removeBriefmapromo(BriefMaPromo $briefmapromo): self
    {
        if ($this->briefmapromo->contains($briefmapromo)) {
            $this->briefmapromo->removeElement($briefmapromo);
            // set the owning side to null (unless already changed)
            if ($briefmapromo->getPromo() === $this) {
                $briefmapromo->setPromo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenants(): Collection
    {
        return $this->apprenants;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenants->contains($apprenant)) {
            $this->apprenants[] = $apprenant;
            $apprenant->setPromo($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->contains($apprenant)) {
            $this->apprenants->removeElement($apprenant);
            // set the owning side to null (unless already changed)
            if ($apprenant->getPromo() === $this) {
                $apprenant->setPromo(null);
            }
        }

        return $this;
    }
=======
>>>>>>> 7e9215b8b667b706bac8381ff69638309b539849
}
