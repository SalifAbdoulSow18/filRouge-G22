<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompetenceRepository;
use ApiPlatform\Core\Annotation\ApiResource; 
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\GpeRepository;

/**
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 * @ApiResource(   
 *      attributes={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Vous n'avez pas access à cette Ressource"
 *          },
 *       collectionOperations={
 *          "get"={"path"="/admin/grpecompetence/competences"} 
 * 
*      } 
 * )
 */
class Competence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer") 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
      * @Groups({"competence:read"})
     */
    private $nomCompetence;

    /** 
     * @ORM\ManyToOne(targetEntity=GpeCompetence::class, inversedBy="competences")  
     *   @Groups({"competence:read"})
     */
    private $gpeCompetence;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCompetence(): ?string
    {
        return $this->nomCompetence;
    }

    public function setNomCompetence(string $nomCompetence): self
    {
        $this->nomCompetence = $nomCompetence;

        return $this;
    }

    public function getGpeCompetence(): ?GpeCompetence
    {
        return $this->gpeCompetence;
    }

    public function setGpeCompetence(?GpeCompetence $gpeCompetence): self
    {
        $this->gpeCompetence = $gpeCompetence;

        return $this;
    }
}
