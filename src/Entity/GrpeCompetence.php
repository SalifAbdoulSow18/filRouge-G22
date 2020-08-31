<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GrpeCompetenceRepository;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=GrpeCompetenceRepository::class)
 * @UniqueEntity("libelle")
 * @ApiResource(
 *      attributes={
 *          "security"="is_granted('ROLE_ADMIN') || is_granted('ROLE_FORMATEUR') || is_granted('ROLE_CM')",
 *          "security_message"="Vous n'avez pas access à cette Ressource"
 *      },
 *      collectionOperations={ 
 *          "grpecompetences_competences"={ 
 *              "method"="GET",
 *              "path"="/admin/grpecompetences/competences",
 *              "normalization_context"={"groups"={"gpecompetence_competences:read"}},
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="Vous n'avez pas access à cette Ressource"
 *          },
 *          "grpecompetences"={
 *              "method"="GET",
 *              "path"="/admin/grpecompetences",
 *              "normalization_context"={"groups"={"gpecompetence:read"}}
 *          }
 *      },
 *      itemOperations={
 *          "getgpecompetence_competence_by_id"={
 *              "path"="/admin/grpecompetences/{id}",
 *              "normalization_context"={"groups"={"gpecompetence_competence_id:read"}},
 *              "method"="GET"
 *          },
 *          "getcompetence_of_one_gpecompetence"={
 *              "path"="/admin/grpecompetences/{id}/competences",
 *              "method"="GET",
 *              "normalization_context"={"groups"={"competenceof_gpecompetence"}}
 *          },
 *          "modify_gprecomp"={
 *              "path"="/admin/grpecompetences/{id}",
 *              "method"="PUT"
 *          }
 *      }
 *)
 */
class GrpeCompetence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"promo_ref_gpecomp_competence:read","referentiel_gpecompetence:read","gpecompetence_competence_id:read","gpecompetence_competences:read","ref_gpecomp_comp:read","gpecompetence:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"promo_ref_gpecomp_competence:read","referentiel_gpecompetence:read","gpecompetence_competence_id:read","gpecompetence_competences:read","gpecompetence:read","ref_gpecomp_comp:read"})
     * @Assert\NotBlank(message="Bindeul dara gayn")
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, mappedBy="grpeCompetence", cascade={"persist"})
     * @ApiSubresource
     * @Groups({"gpecompetence_competence_id:read","gpecompetence_competences:read","competenceof_gpecompetence","ref_gpecomp_comp:read","promo_ref_gpecomp_competence:read"})
     */
    private $competences;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, mappedBy="grpeCompetence", cascade={"persist"})
     */
    private $referentiels;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
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

    /**
     * @return Collection|Competence[]
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
            $competence->addGrpeCompetence($this);
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        if ($this->competences->contains($competence)) {
            $this->competences->removeElement($competence);
            $competence->removeGrpeCompetence($this);
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
            $referentiel->addGrpeCompetence($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiels->contains($referentiel)) {
            $this->referentiels->removeElement($referentiel);
            $referentiel->removeGrpeCompetence($this);
        }

        return $this;
    }
}
