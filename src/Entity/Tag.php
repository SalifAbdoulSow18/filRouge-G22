<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 * @ApiResource(
 *      attributes={
 *          "security"="is_granted('ROLE_ADMIN')||is_granted('ROLE_FORMATEUR')",
 *          "security_message"="Vous n'avez pas access à cette Ressource"
 *      },
 *      collectionOperations={
 *          "get"={"path"="/admin/tags"},
 *          "post"={"path"="/admin/tags"}
 *      },
 *      itemOperations={
 *          "get"={"path"="/admin/tags/{id}"},
 *          "put"={"path"="/admin/tags/{id}"}
 *      }
 * )
 */
class Tag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
<<<<<<< HEAD
     * @Groups({"brief_assigned","briefs:read","brief_gpe_promo","brief_of_promo","brief_brouillon","brief_of_one_promo"})
=======
     * @Groups({"briefs:read"})
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeTag::class, inversedBy="tags")
     */
    private $groupeTag;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message="this field cannot be empty !!!")
<<<<<<< HEAD
     * @Groups({"brief_assigned","briefs:read","brief_gpe_promo","brief_of_promo","brief_brouillon","brief_of_one_promo"})
=======
     * @Groups({"briefs:read"})
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
     */
    private $nomTag;

    /**
     * @ORM\ManyToMany(targetEntity=Brief::class, mappedBy="tag")
     */
    private $briefs;

    public function __construct()
    {
        $this->groupeTag = new ArrayCollection();
        $this->briefs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|GroupeTag[]
     */
    public function getGroupeTag(): Collection
    {
        return $this->groupeTag;
    }

    public function addGroupeTag(GroupeTag $groupeTag): self
    {
        if (!$this->groupeTag->contains($groupeTag)) {
            $this->groupeTag[] = $groupeTag;
        }

        return $this;
    }

    public function removeGroupeTag(GroupeTag $groupeTag): self
    {
        if ($this->groupeTag->contains($groupeTag)) {
            $this->groupeTag->removeElement($groupeTag);
        }

        return $this;
    }

    public function getNomTag(): ?string
    {
        return $this->nomTag;
    }

    public function setNomTag(string $nomTag): self
    {
        $this->nomTag = $nomTag;

        return $this;
    }

    /**
     * @return Collection|Brief[]
     */
    public function getBriefs(): Collection
    {
        return $this->briefs;
    }

    public function addBrief(Brief $brief): self
    {
        if (!$this->briefs->contains($brief)) {
            $this->briefs[] = $brief;
            $brief->addTag($this);
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        if ($this->briefs->contains($brief)) {
            $this->briefs->removeElement($brief);
            $brief->removeTag($this);
        }

        return $this;
    }
}
