<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 * @ApiResource(
 * attributes={
 *          "security"="is_granted('ROLE_ADMIN')||is_granted('ROLE_FORMATEUR')||is_granted('ROLE_CM')",
 *          "security_message"="Vous n'avez pas access à cette Ressource"
 *     },
 *     collectionOperations={
 *          "Competence_and_niveau"={
 *              "path"="/admin/competences",
 *              "method"="GET",
 *              "normalization_context"={"groups"={"niveau:read"}}
 *          },
 *          "post"={
 *              "path"="/admin/competences",
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="Vous n'avez pas access à cette Ressource"
 *          }
 *      },
 *      itemOperations={
 *          "get"={
 *              "path"="/admin/competences/{id}",
 *              "normalization_context"={"groups"={"niveau:read"}}
 *          },
 *          "put"={
 *              "path"="/admin/competences/{id}",
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="Vous n'avez pas access à cette Ressource"
 *          }
 * }
 * )
 */
class Competence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"modou:read","japonais:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"modou:read","japonais:read"})
     */
    private $nomCompetence;

    /**
     * @ORM\ManyToMany(targetEntity=GrpeCompetence::class, inversedBy="competences", cascade={"persist"})
     */
    private $grpeCompetence;

    /**
     * @ORM\ManyToMany(targetEntity=Niveau::class, mappedBy="competence")
     * @Groups({"niveau:read"})
     */
    private $niveaux;

    public function __construct()
    {
        $this->grpeCompetence = new ArrayCollection();
        $this->niveaux = new ArrayCollection();
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
}
