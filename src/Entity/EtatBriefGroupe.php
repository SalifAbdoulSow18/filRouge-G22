<?php

namespace App\Entity;

<<<<<<< HEAD
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EtatBriefGroupeRepository;
use Symfony\Component\Serializer\Annotation\Groups;
=======
use App\Repository\EtatBriefGroupeRepository;
use Doctrine\ORM\Mapping as ORM;
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d

/**
 * @ORM\Entity(repositoryClass=EtatBriefGroupeRepository::class)
 */
class EtatBriefGroupe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Brief::class, inversedBy="etatbriefgroupe")
     */
    private $brief;

    /**
     * @ORM\ManyToOne(targetEntity=Groupe::class, inversedBy="etatbriefgroupe")
<<<<<<< HEAD
     * @Groups({"brief_assigned","brief_gpe_promo","brief_of_promo","brief_of_one_promo"})
=======
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
     */
    private $groupe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getBrief(): ?Brief
    {
        return $this->brief;
    }

    public function setBrief(?Brief $brief): self
    {
        $this->brief = $brief;

        return $this;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }
}
