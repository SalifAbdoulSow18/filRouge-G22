<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
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
    private $grpTag_Tag;

    public function __construct()
    {
        $this->grpTag_Tag = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|GroupeTag[]
     */
    public function getGrpTagTag(): Collection
    {
        return $this->grpTag_Tag;
    }

    public function addGrpTagTag(GroupeTag $grpTagTag): self
    {
        if (!$this->grpTag_Tag->contains($grpTagTag)) {
            $this->grpTag_Tag[] = $grpTagTag;
        }

        return $this;
    }

    public function removeGrpTagTag(GroupeTag $grpTagTag): self
    {
        if ($this->grpTag_Tag->contains($grpTagTag)) {
            $this->grpTag_Tag->removeElement($grpTagTag);
        }

        return $this;
    }
}
