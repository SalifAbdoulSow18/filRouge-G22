<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GpeCompetenceRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GpeCompetenceRepository::class)
 * @ApiResource( 
 * normalizationContext={"groups"={"competence:read"}},
 *  attributes={
 *       "security"="is_granted('ROLE_ADMIN')",
 *       "security_message"="Vous n'avez pas access à cette Ressource"
* },
 * collectionOperations={ 
 *   "post"={ 
 *        "path"="admin/grpecompetences",
*    }
*},  
 *      itemOperations={
 *          "get"={"path"="/admin/grpecompetences/{id}"},
 *          "put"={"path"="/admin/grpecompetences/{id}"},
 * 
 *           "get"={ 
 *                      "security"="is_granted('GET' ,subject)", 
 *                      "path"="/admin/grpecompetence/{id}/competences" , 
 *              },
 *  
 *       }
 * 
 * )
 */
class GpeCompetence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"competence:read"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"competence:read"})
     */
    private $libelle;

    /**
     * @Groups({"competence:read"})
     * @ORM\OneToMany(targetEntity=Competence::class, mappedBy="gpeCompetence")
     */
    private $competences;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, mappedBy="grpeCompetence_referentiel")
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
            $competence->setGpeCompetence($this);
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        if ($this->competences->contains($competence)) {
            $this->competences->removeElement($competence);
            // set the owning side to null (unless already changed)
            if ($competence->getGpeCompetence() === $this) {
                $competence->setGpeCompetence(null);
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
            $referentiel->addGrpeCompetenceReferentiel($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiels->contains($referentiel)) {
            $this->referentiels->removeElement($referentiel);
            $referentiel->removeGrpeCompetenceReferentiel($this);
        }

        return $this;
    }
}
