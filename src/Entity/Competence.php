<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 * @ApiResource(
 *      attributes={
 *          "security"="is_granted('ROLE_ADMIN')||is_granted('ROLE_FORMATEUR')||is_granted('ROLE_CM')",
 *          "security_message"="Vous n'avez pas access à cette Ressource"
 *      },
 *      collectionOperations={
 *          "Competence_and_niveau"={
 *              "path"="/admin/competences",
 *              "method"="GET",
 *              "normalization_context"={"groups"={"competence_niveau:read"}}
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *              "path"="/admin/competences/{id}",
 *              "normalization_context"={"groups"={"competence_niveau:read"}}
 *          },
 *          "put"={
 *              "path"="/admin/competences/{id}",
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="Vous n'avez pas access à cette Ressource"
 *          }
 *      }
 * )
 */
class Competence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"brief_assigned","brief_brouillon","brief_gpe_promo","brief_of_promo","brief_of_one_promo","promo_ref_gpecomp_competence:read","ref_gpecomp_comp:read","gpecompetence_competence_id:read","gpecompetence_competences:read","competenceof_gpecompetence", "competence_niveau:read","briefs:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"brief_assigned","brief_brouillon","brief_gpe_promo","brief_of_promo","brief_of_one_promo","promo_ref_gpecomp_competence:read","ref_gpecomp_comp:read","gpecompetence_competence_id:read","gpecompetence_competences:read","competenceof_gpecompetence", "competence_niveau:read","briefs:read"})
     * @Assert\NotBlank(message="Bindeul dara gayn")
     */
    private $nomCompetence;

    /**
     * @ORM\ManyToMany(targetEntity=GrpeCompetence::class, inversedBy="competences", cascade={"persist"})
     */
    private $grpeCompetence;

    /**
     * @ORM\ManyToMany(targetEntity=Niveau::class, mappedBy="competence", cascade={"persist"})
     * @Groups({"competence_niveau:read"})
     */
    private $niveaux;

    /**
     * @ORM\OneToMany(targetEntity=CompetencesValides::class, mappedBy="competences")
     */
    private $competencesValides;

    public function __construct()
    {
        $this->grpeCompetence = new ArrayCollection();
        $this->niveaux = new ArrayCollection();
        $this->competencesValides = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCompetence(): ?string
    {
        return $this->nomCompetence;
    }

    public function setNomCompetence(string $nomCompetence): self
    {
        $this->nomCompetence = $nomCompetence;

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

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux[] = $niveau;
            $niveau->addCompetence($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveaux->contains($niveau)) {
            $this->niveaux->removeElement($niveau);
            $niveau->removeCompetence($this);
        }

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
            $competencesValide->setCompetences($this);
        }

        return $this;
    }

    public function removeCompetencesValide(CompetencesValides $competencesValide): self
    {
        if ($this->competencesValides->contains($competencesValide)) {
            $this->competencesValides->removeElement($competencesValide);
            // set the owning side to null (unless already changed)
            if ($competencesValide->getCompetences() === $this) {
                $competencesValide->setCompetences(null);
            }
        }

        return $this;
    }
}
