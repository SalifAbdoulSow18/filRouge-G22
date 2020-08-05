<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 * @ApiResource(
 *    attributes={
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
 * }
 * )
 */
class Tag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeTag::class, inversedBy="tags")
     */
    private $groupeTag;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank( message="this field cannot be empty !!!" )
     */
    private $nomTag;

    public function __construct()
    {
        $this->groupeTag = new ArrayCollection();
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
}
