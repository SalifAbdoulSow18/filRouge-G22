<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReferentielRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ReferentielRepository::class)
 * @ApiResource(
 *      attributes={
 *          "security"="is_granted('ROLE_ADMIN')||is_granted('ROLE_FORMATEUR')||is_granted('ROLE_CM')",
 *          "security_message"="Vous n'avez pas access à cette Ressource"
 *      },
 *      collectionOperations={
 *          "referentiel_gpecomp"={
 *              "path"="/admin/referentiels",
 *              "normalization_context"={"groups"={"referentiel_gpecompetence:read"}},
 *          "referentiel_gpecomp"={
 *              "path"="/admin/referentiels",
 *              "normalization_context"={"groups"={"referentiel_gpecompetence:read"}},
 *          "ref_gpecomp"={
 *              "path"="/admin/referentiels",
 *              "normalization_context"={"groups"={"refgpecomp:read"}},
 *              "method"="GET"
 *          },
 *          "gpecomp_comp"={
 *              "path"="/admin/referentiels/grpecompetences",
 *              "normalization_context"={"groups"={"ref_gpecomp_comp:read"}},
 *              "normalization_context"={"groups"={"ref_gpecomp_comp:read"}},
 *              "normalization_context"={"groups"={"gpecompcomp:read"}},
 *              "method"="GET"
 *          },
 *          "post"={"path"="/admin/referentiels"}
 *      },
 *      itemOperations={
 *          "referentiels_gpecompetences_id"={
 *              "path"="/admin/referentiels/{id}",
 *              "normalization_context"={"groups"={"referentiel_gpecompetence:read"}},
 *              "method"="GET"
 *          },
 *          "gpecomp_comp_id"={
 *              "path"="/admin/referentiels/{id}/grpecompetences/{id2}",
 *              "normalization_context"={"groups"={"ref_gpecomp_comp:read"}},
 *          "ref_gpecomp_id"={
 *              "path"="/admin/referentiels/{id}",
 *              "normalization_context"={"groups"={"refgpecomp:read"}},
 *              "method"="GET"
 *          },
 *          "gpecomp_comp_id"={
 *              "path"="/admin/referentiels/grpecompetences/{id}",
 *              "normalization_context"={"groups"={"gpecompcomp:read"}},
 *              "method"="GET"
 *          },
 *          "put"={"path"="/admin/referentiels/{id}"}
 *      }
 * )
 */
class Referentiel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"brief_of_one_promo","promo_ref_gpecomp_competence:read","referentiel_gpecompetence:read","prom_ref_app_form", "referentiel_formateur_gpe:read","ref_gpecomp_comp:read","apprenant_id_promo:read","put_ref_promo:read"})
     * @Groups({"promo_ref_gpecomp_competence:read","referentiel_gpecompetence:read","prom_ref_app_form", "referentiel_formateur_gpe:read","ref_gpecomp_comp:read","apprenant_id_promo:read","put_ref_promo:read"})
     * @Groups({"refgpecomp:read"})
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, inversedBy="referentiels", cascade={"persist"})
     */
    private $promo;

    /**
     * @ORM\ManyToMany(targetEntity=GrpeCompetence::class, inversedBy="referentiels", cascade={"persist"})
     * @Groups({"referentiel_gpecompetence:read","ref_gpecomp_comp:read","promo_ref_gpecomp_competence:read"})
     * @ORM\ManyToMany(targetEntity=GrpeCompetence::class, inversedBy="referentiels", cascade={"persist"})
     * @Groups({"referentiel_gpecompetence:read","ref_gpecomp_comp:read","promo_ref_gpecomp_competence:read"})
     * @ORM\ManyToMany(targetEntity=GrpeCompetence::class, inversedBy="referentiels")
     * @Groups({"refgpecomp:read","gpecompcomp:read","reprogpecompcomp"})
     */
    private $grpeCompetence;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"brief_of_one_promo","promo_ref_gpecomp_competence:read","prom_ref_app_form", "referentiel_formateur_gpe:read","referentiel_gpecompetence:read","ref_gpecomp_comp:read","put_ref_promo:read"})
     * @Groups({"promo_ref_gpecomp_competence:read","prom_ref_app_form", "referentiel_formateur_gpe:read","referentiel_gpecompetence:read","ref_gpecomp_comp:read","put_ref_promo:read"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Promo::class, mappedBy="referentiel")
     */
    private $promos;

    /**
     * @ORM\OneToMany(targetEntity=CompetencesValides::class, mappedBy="referentiel")
     */
    private $competencesValides;

    public function __construct()
    {
        $this->promo = new ArrayCollection();
        $this->grpeCompetence = new ArrayCollection();
        $this->promos = new ArrayCollection();
<<<<<<< HEAD
        $this->competencesValides = new ArrayCollection();
=======
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Promo[]
     */
    public function getPromo(): Collection
    {
        return $this->promo;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promo->contains($promo)) {
            $this->promo[] = $promo;
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promo->contains($promo)) {
            $this->promo->removeElement($promo);
        }

        return $this;
    }

    /**
     * @return Collection|GrpeCompetence[]
     */
    public function getGrpeCompetence(): Collection
    {
        return $this->grpeCompetence;
    }

    public function addGrpeCompetence(GrpeCompetence $grpeCompetence): self
    {
        if (!$this->grpeCompetence->contains($grpeCompetence)) {
            $this->grpeCompetence[] = $grpeCompetence;
        }

        return $this;
    }

    public function removeGrpeCompetence(GrpeCompetence $grpeCompetence): self
    {
        if ($this->grpeCompetence->contains($grpeCompetence)) {
            $this->grpeCompetence->removeElement($grpeCompetence);
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

    /**
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
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
            $competencesValide->setReferentiel($this);
        }

        return $this;
    }

    public function removeCompetencesValide(CompetencesValides $competencesValide): self
    {
        if ($this->competencesValides->contains($competencesValide)) {
            $this->competencesValides->removeElement($competencesValide);
            // set the owning side to null (unless already changed)
            if ($competencesValide->getReferentiel() === $this) {
                $competencesValide->setReferentiel(null);
            }
        }

        return $this;
    }
=======
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
}
