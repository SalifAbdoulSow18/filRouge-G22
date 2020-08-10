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

/**
 * @ORM\Entity(repositoryClass=GrpeCompetenceRepository::class)
 * @ApiResource(  
 * collectionOperations={ 
 *   "grt"={ 
 *      "method"="GET" ,
 *        "path"="/admin/grpecompetences/competences" ,
 *        "normalization_context"={"groups"={"modou:read"}} ,
 *        "security"="is_granted('ROLE_ADMIN')",
 *        "security_message"="Vous n'avez pas access à cette Ressource"
 *    } ,
 *    "grp"={
 *              "method"="GET",
 *        "path"="/admin/grpecompetences" ,
 *           "security"="is_granted('ROLE_ADMIN')",
 *       "security_message"="Vous n'avez pas access à cette Ressource"
 *} ,
 *    "grp_post"={
 *              "method"="POST" ,
 *        "path"="/admin/grpecompetences" ,
 *           "security"="is_granted('ROLE_ADMIN')",
 *       "security_message"="Vous n'avez pas access à cette Ressource"
 *}
 *}, 
 *itemOperations={
 *           "geCompetence_by_id"={"path"="/admin/grpecompetences/{id}","method"="GET"},
 *           "geCompetence_and_competence"={
 *              "path"="/admin/grpecompetences/{id}",
 *              "method"="GET",
 *              "normalization_context"={"groups"={"japonais:read"}}
 *           }
*}
 * )
 */
class GrpeCompetence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"modou:read","japonais:read","gpecompcomp:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"modou:read","japonais:read"})
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, mappedBy="grpeCompetence")
     * @ApiSubresource
     * @Groups({"modou:read","japonais:read","gpecompcomp:read","reprogpecompcomp"})
     */
    private $competences;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, mappedBy="grpeCompetence")
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
