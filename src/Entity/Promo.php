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
 *          "referentiel_formateur_gpe"={
 *              "path"="/admin/promo",
 *              "normalization_context"={"groups"={"referentiel_formateur_gpe:read"}},
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
 *              "normalization_context"={"groups"={"promo_ref_gpecomp_competence:read"}},
 *              "method"="GET"
 *          },
 *          "ref_prom_gpecom_comp_id"={
 *              "path"="/admin/promo/{id}",
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
 *      }
 * )
 */
class Promo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"promo_ref_gpecomp_competence:read","prom_ref_app_form","put_ref_promo:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"prom_ref_app_form", "referentiel_formateur_gpe:read","promo_ref_gpecomp_competence:read","apprenant_id_promo:read","put_ref_promo:read","statut_groupe:read"}) 
     */
    private $libelle;

    /**
     * @ORM\Column(type="date")
     * @Groups({"prom_ref_app_form","referentiel_formateur_gpe:read","promo_ref_gpecomp_competence:read","apprenant_id_promo:read"})
     */
    private $annee;

    /**
     * @ORM\Column(type="date")
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
     */
    private $formateurs;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="promo",cascade={"persist"})
     * @Groups({"referentiel_formateur_gpe:read","apprenant_id_promo:read"})
     */
    private $groupe;

    

    /**
     * @ORM\OneToMany(targetEntity=CompetencesValides::class, mappedBy="promo")
     * @Groups({"promo_stat"})
     */
    private $competencesValides;

    /**
     * @ORM\ManyToOne(targetEntity=Referentiel::class, inversedBy="promos")
     * @Groups({"un:read","promo_stat"})
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

    public function __construct()
    {
        $this->formateurs = new ArrayCollection();
        $this->groupe = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
        $this->competencesValides = new ArrayCollection();
        $this->chat = new ArrayCollection();
        $this->briefmapromo = new ArrayCollection();
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
}
