<?php

namespace App\Entity;

<<<<<<< HEAD
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompetencesValidesRepository;
use Symfony\Component\Serializer\Annotation\Groups;
=======
use App\Repository\CompetencesValidesRepository;
use Doctrine\ORM\Mapping as ORM;
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d

/**
 * @ORM\Entity(repositoryClass=CompetencesValidesRepository::class)
 */
class CompetencesValides
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $niveau1;

    /**
     * @ORM\Column(type="boolean")
     */
    private $niveau2;

    /**
     * @ORM\Column(type="boolean")
     */
    private $niveau3;

    /**
     * @ORM\ManyToOne(targetEntity=Competence::class, inversedBy="competencesValides")
     */
    private $competences;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="competencesValides")
     */
    private $apprenant;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="competencesValides")
     */
    private $promo;

<<<<<<< HEAD
    /**
     * @ORM\ManyToOne(targetEntity=Referentiel::class, inversedBy="competencesValides")
     */
    private $referentiel;

=======
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveau1(): ?bool
    {
        return $this->niveau1;
    }

    public function setNiveau1(bool $niveau1): self
    {
        $this->niveau1 = $niveau1;

        return $this;
    }

    public function getNiveau2(): ?bool
    {
        return $this->niveau2;
    }

    public function setNiveau2(bool $niveau2): self
    {
        $this->niveau2 = $niveau2;

        return $this;
    }

    public function getNiveau3(): ?bool
    {
        return $this->niveau3;
    }

    public function setNiveau3(bool $niveau3): self
    {
        $this->niveau3 = $niveau3;

        return $this;
    }

    public function getCompetences(): ?Competence
    {
        return $this->competences;
    }

    public function setCompetences(?Competence $competences): self
    {
        $this->competences = $competences;

        return $this;
    }

    public function getApprenant(): ?Apprenant
    {
        return $this->apprenant;
    }

    public function setApprenant(?Apprenant $apprenant): self
    {
        $this->apprenant = $apprenant;

        return $this;
    }

    public function getPromo(): ?Promo
    {
        return $this->promo;
    }

    public function setPromo(?Promo $promo): self
    {
        $this->promo = $promo;

        return $this;
    }
<<<<<<< HEAD

    public function getReferentiel(): ?Referentiel
    {
        return $this->referentiel;
    }

    public function setReferentiel(?Referentiel $referentiel): self
    {
        $this->referentiel = $referentiel;

        return $this;
    }
=======
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
}
