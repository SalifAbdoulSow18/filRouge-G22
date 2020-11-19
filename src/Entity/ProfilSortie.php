<?php

namespace App\Entity;

use App\Entity\Apprenant;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfilSortieRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProfilSortieRepository::class)
 * @ApiResource(
 *      
 * collectionOperations={
 *      "get_profils_sortie"={
 *          "method"= "GET",
 *          "path" = "/admin/profilsorties",
 *          "normalization_context"={"groups"={"profil_sortie":"read"}},
 *          "security" = "(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))"
 *      },
 * 
 *      "create_profils_sortie"={
 *          "method"= "POST",
 *          "path" = "/admin/profilsorties",
 *          "security" = "(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))"
 *      },
 * 
 *     "show_profilsortie_by_groupe"={
 *          "method"= "GET",
 *          "path" = "/admin/promo/{id}/profilsorties",
 *          "security" = "(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *          "route_name"="getApprenantOfOnePromoByProfilsortie",
 *      }
 * },
 * 
 * itemOperations={
 *  
 *      "get_one_profils_sortie"={
 *          "method"= "GET",
 *          "path" = "/admin/profilsorties/{id}",
 *          "security" = "(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))"
 *      },
 * 
 *      "edit_profils_sortie"={
 *          "method"= "PUT",
 *          "path" = "/admin/profilsorties/{id}",
 *          "security" = "(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))"
 *      },
 * 
 *     "show_profilsortie_promo"={
 *          "method"= "GET",
 *          "path" = "/admin/promo/{id1}/profilsorties/{id2}",
 *          "security" = "(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *          "route_name"="getApprenantofOneProfilsortieOfOnePromo",
 *      }
 * }
 * )
 */
class ProfilSortie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"profil_sortie:read","profil_sortie_id:read","apprenant_profilsortie_promo"})
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"profil_sortie:read","profil_sortie_id:read","apprenant_profilsortie_promo"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="profilSortie")
     */
    private $apprenant;

    public function __construct()
    {
        $this->apprenant = new ArrayCollection();
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
     * @return Collection|Apprenant[]
     */
    public function getApprenant(): Collection
    {
        return $this->apprenant;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenant->contains($apprenant)) {
            $this->apprenant[] = $apprenant;
            $apprenant->setProfilSortie($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenant->contains($apprenant)) {
            $this->apprenant->removeElement($apprenant);
            // set the owning side to null (unless already changed)
            if ($apprenant->getProfilSortie() === $this) {
                $apprenant->setProfilSortie(null);
            }
        }

        return $this;
    }
}
