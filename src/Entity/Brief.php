<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BriefRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BriefRepository::class)
 * @ApiResource(
 *      attributes={
 *          "security"="is_granted('ROLE_ADMIN')||is_granted('ROLE_FORMATEUR')||is_granted('ROLE_CM')",
 *          "security_message"="Vous n'avez pas access à cette Ressource"
 *      },
 *      collectionOperations={
 *          "briefs_niveau_competence_livrablesattendu_tag_ressource"={
 *              "path"="/formateurs/briefs",
 *              "method"="GET",
 *              "normalization_context"={"groups"={"briefs:read"}}
 *          },
 *          "get_brief_of_one_groupe"={
 *              "method"="GET",
 *              "path"="/promo/{id1}/groupe/{id2}/briefs",
 *              "route_name"="get_brief_of_one_groupe"
 *          },
 *      }
 * )
 */
class Brief
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"briefs:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"briefs:read"})
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"briefs:read"})
     */
    private $nomBrief;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"briefs:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"briefs:read"})
     */
    private $contexte;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"briefs:read"})
     */
    private $modalitePedagogique;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"briefs:read"})
     */
    private $critereDevaluation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"briefs:read"})
     */
    private $modaliteDevaluation;

    /**
     * @ORM\Column(type="blob")
     * @Groups({"briefs:read"})
     */
    private $imagePromo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"briefs:read"})
     */
    private $archiver;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"briefs:read"})
     */
    private $createAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"briefs:read"})
     */
    private $etat;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="briefs")
     * @Groups({"briefs:read"})
     */
    private $tag;

    /**
     * @ORM\ManyToMany(targetEntity=LivrableAttendu::class, inversedBy="briefs")
     * @Groups({"briefs:read"})
     */
    private $livrableattendu;

    /**
     * @ORM\ManyToMany(targetEntity=Niveau::class, inversedBy="briefs")
     * @Groups({"briefs:read"})
     */
    private $niveau;

    /**
     * @ORM\OneToMany(targetEntity=Ressource::class, mappedBy="brief")
     * @Groups({"briefs:read"})
     */
    private $ressource;

    /**
     * @ORM\OneToMany(targetEntity=BriefMaPromo::class, mappedBy="brief")
     */
    private $briefmapromo;

    /**
     * @ORM\OneToMany(targetEntity=EtatBriefGroupe::class, mappedBy="brief")
     */
    private $etatbriefgroupe;

    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="briefs")
     */
    private $formateur;

    public function __construct()
    {
        $this->tag = new ArrayCollection();
        $this->livrableattendu = new ArrayCollection();
        $this->niveau = new ArrayCollection();
        $this->ressource = new ArrayCollection();
        $this->briefmapromo = new ArrayCollection();
        $this->etatbriefgroupe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getNomBrief(): ?string
    {
        return $this->nomBrief;
    }

    public function setNomBrief(string $nomBrief): self
    {
        $this->nomBrief = $nomBrief;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getContexte(): ?string
    {
        return $this->contexte;
    }

    public function setContexte(string $contexte): self
    {
        $this->contexte = $contexte;

        return $this;
    }

    public function getModalitePedagogique(): ?string
    {
        return $this->modalitePedagogique;
    }

    public function setModalitePedagogique(string $modalitePedagogique): self
    {
        $this->modalitePedagogique = $modalitePedagogique;

        return $this;
    }

    public function getCritereDevaluation(): ?string
    {
        return $this->critereDevaluation;
    }

    public function setCritereDevaluation(string $critereDevaluation): self
    {
        $this->critereDevaluation = $critereDevaluation;

        return $this;
    }

    public function getModaliteDevaluation(): ?string
    {
        return $this->modaliteDevaluation;
    }

    public function setModaliteDevaluation(string $modaliteDevaluation): self
    {
        $this->modaliteDevaluation = $modaliteDevaluation;

        return $this;
    }

    public function getImagePromo()
    {
        return $this->imagePromo;
    }

    public function setImagePromo($imagePromo): self
    {
        $this->imagePromo = $imagePromo;

        return $this;
    }

    public function getArchiver(): ?string
    {
        return $this->archiver;
    }

    public function setArchiver(string $archiver): self
    {
        $this->archiver = $archiver;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tag->contains($tag)) {
            $this->tag->removeElement($tag);
        }

        return $this;
    }

    /**
     * @return Collection|LivrableAttendu[]
     */
    public function getLivrableattendu(): Collection
    {
        return $this->livrableattendu;
    }

    public function addLivrableattendu(LivrableAttendu $livrableattendu): self
    {
        if (!$this->livrableattendu->contains($livrableattendu)) {
            $this->livrableattendu[] = $livrableattendu;
        }

        return $this;
    }

    public function removeLivrableattendu(LivrableAttendu $livrableattendu): self
    {
        if ($this->livrableattendu->contains($livrableattendu)) {
            $this->livrableattendu->removeElement($livrableattendu);
        }

        return $this;
    }

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveau(): Collection
    {
        return $this->niveau;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveau->contains($niveau)) {
            $this->niveau[] = $niveau;
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveau->contains($niveau)) {
            $this->niveau->removeElement($niveau);
        }

        return $this;
    }

    /**
     * @return Collection|Ressource[]
     */
    public function getRessource(): Collection
    {
        return $this->ressource;
    }

    public function addRessource(Ressource $ressource): self
    {
        if (!$this->ressource->contains($ressource)) {
            $this->ressource[] = $ressource;
            $ressource->setBrief($this);
        }

        return $this;
    }

    public function removeRessource(Ressource $ressource): self
    {
        if ($this->ressource->contains($ressource)) {
            $this->ressource->removeElement($ressource);
            // set the owning side to null (unless already changed)
            if ($ressource->getBrief() === $this) {
                $ressource->setBrief(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BriefMaPromo[]
     */
    public function getBriefmapromo(): Collection
    {
        return $this->briefmapromo;
    }

    public function addBriefmapromo(BriefMaPromo $briefmapromo): self
    {
        if (!$this->briefmapromo->contains($briefmapromo)) {
            $this->briefmapromo[] = $briefmapromo;
            $briefmapromo->setBrief($this);
        }

        return $this;
    }

    public function removeBriefmapromo(BriefMaPromo $briefmapromo): self
    {
        if ($this->briefmapromo->contains($briefmapromo)) {
            $this->briefmapromo->removeElement($briefmapromo);
            // set the owning side to null (unless already changed)
            if ($briefmapromo->getBrief() === $this) {
                $briefmapromo->setBrief(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EtatBriefGroupe[]
     */
    public function getEtatbriefgroupe(): Collection
    {
        return $this->etatbriefgroupe;
    }

    public function addEtatbriefgroupe(EtatBriefGroupe $etatbriefgroupe): self
    {
        if (!$this->etatbriefgroupe->contains($etatbriefgroupe)) {
            $this->etatbriefgroupe[] = $etatbriefgroupe;
            $etatbriefgroupe->setBrief($this);
        }

        return $this;
    }

    public function removeEtatbriefgroupe(EtatBriefGroupe $etatbriefgroupe): self
    {
        if ($this->etatbriefgroupe->contains($etatbriefgroupe)) {
            $this->etatbriefgroupe->removeElement($etatbriefgroupe);
            // set the owning side to null (unless already changed)
            if ($etatbriefgroupe->getBrief() === $this) {
                $etatbriefgroupe->setBrief(null);
            }
        }

        return $this;
    }

    public function getFormateur(): ?Formateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Formateur $formateur): self
    {
        $this->formateur = $formateur;

        return $this;
    }
}
