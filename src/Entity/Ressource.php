<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RessourceRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=RessourceRepository::class)
 */
class Ressource
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
     * @ORM\Column(type="string", length=255)
<<<<<<< HEAD
     * @Groups({"brief_assigned","briefs:read","brief_gpe_promo","brief_of_promo","brief_brouillon","brief_of_one_promo"})
=======
     * @Groups({"briefs:read"})
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
<<<<<<< HEAD
     * @Groups({"brief_assigned","briefs:read","brief_gpe_promo","brief_of_promo","brief_brouillon","brief_of_one_promo"})
=======
     * @Groups({"briefs:read"})
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
<<<<<<< HEAD
     * @Groups({"brief_assigned","briefs:read","brief_gpe_promo","brief_of_promo","brief_brouillon","brief_of_one_promo"})
=======
     * @Groups({"briefs:read"})
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
     */
    private $piece_jointe;

    /**
     * @ORM\Column(type="string", length=255)
<<<<<<< HEAD
     * @Groups({"brief_assigned","briefs:read","brief_gpe_promo","brief_of_promo","brief_brouillon","brief_of_one_promo"})
=======
     * @Groups({"briefs:read"})
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity=Brief::class, inversedBy="ressource")
     */
    private $brief;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPieceJointe(): ?string
    {
        return $this->piece_jointe;
    }

    public function setPieceJointe(string $piece_jointe): self
    {
        $this->piece_jointe = $piece_jointe;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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
}
