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
 *          "ref_gpecomp"={
 *              "path"="/admin/referentiels",
 *              "normalization_context"={"groups"={"refgpecomp:read"}},
 *              "method"="GET"
 *          },
 *          "gpecomp_comp"={
 *              "path"="/admin/referentiels/grpecompetences",
 *              "normalization_context"={"groups"={"gpecompcomp:read"}},
 *              "method"="GET"
 *          },
 *          "post"={"path"="/admin/referentiels"}
 *      },
 *      itemOperations={
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
     * @Groups({"refgpecomp:read"})
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, inversedBy="referentiels")
     */
    private $promo;

    /**
     * @ORM\ManyToMany(targetEntity=GrpeCompetence::class, inversedBy="referentiels")
     * @Groups({"refgpecomp:read","gpecompcomp:read","reprogpecompcomp"})
     */
    private $grpeCompetence;

    public function __construct()
    {
        $this->promo = new ArrayCollection();
        $this->grpeCompetence = new ArrayCollection();
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
}
