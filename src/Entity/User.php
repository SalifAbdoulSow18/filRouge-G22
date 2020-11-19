<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"admin"="Admin","apprenant"="Apprenant", "cm"="Cm" , "formateur"="Formateur" ,"user"="User"})
 * @ApiResource( 
 * normalizationContext={"groups"={"user:read"}},
 *  attributes={
 *       "security"="is_granted('ROLE_ADMIN')",
 *       "security_message"="Vous n'avez pas access à cette Ressource"
* },
 * collectionOperations={
 *   "get"={"path"="/admin/users"},
*    "post"={"path"="/admin/users"}
*},
*   itemOperations={
*   "get"={"path"="/admin/users/{id}"},
*   "put"={"path"="/admin/users/{id}"},
*   "delete"={"path"="/admin/users/{id}"}
*}
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"brief_assigned","user:read","profilusers:read","brief_gpe_promo","brief_of_promo","brief_of_one_promo"})
     * @Groups({"user:read","profilusers:read","apprenant_profilsortie_promo","apprenant_promo_profilsortie"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"brief_assigned","user:read","referentiel_formateur_gpe:read","profilusers:read","brief_gpe_promo","brief_of_promo","brief_of_one_promo"})
     * @Groups({"apprenant_profilsortie_promo","user:read","referentiel_formateur_gpe:read","profilusers:read","apprenant_promo_profilsortie"})
     */
    private $email;


    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
<<<<<<< HEAD
     * @Groups({"brief_assigned","brief_gpe_promo","brief_of_promo","brief_of_one_promo","user:read","referentiel_formateur_gpe:read","profilusers:read","apprenant_id_promo:read"})
=======
     * @Groups({"user:read","referentiel_formateur_gpe:read","profilusers:read","apprenant_id_promo:read"})
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
<<<<<<< HEAD
     * @Groups({"brief_assigned","brief_gpe_promo","brief_of_promo","brief_of_one_promo","user:read", "referentiel_formateur_gpe:read","profilusers:read","apprenant_id_promo:read"})
=======
     * @Groups({"user:read", "referentiel_formateur_gpe:read","profilusers:read","apprenant_id_promo:read","apprenant_profilsortie_promo","apprenant_promo_profilsortie"})
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
<<<<<<< HEAD
     * @Groups({"brief_assigned","brief_gpe_promo","brief_of_promo","brief_of_one_promo","user:read", "referentiel_formateur_gpe:read","profilusers:read"})
=======
     * @Groups({"user:read", "referentiel_formateur_gpe:read","profilusers:read","apprenant_profilsortie_promo","apprenant_profilsortie_promo"})
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"brief_assigned","brief_gpe_promo","brief_of_promo","brief_of_one_promo","user:read","profilusers:read"})
     * @Groups({"user:read","profilusers:read","apprenant_profilsortie_promo"})
     */
    private $adress;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users")
     */
    private $profil;

    /**
     * @ORM\OneToMany(targetEntity=Chat::class, mappedBy="user")
<<<<<<< HEAD
=======
     * Groups({"chat_apprenant:read"})
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
     */
    private $chats;

    public function __construct()
    {
        $this->chats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this->profil->getLibelle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    /**
     * @return Collection|Chat[]
     */
    public function getChats(): Collection
    {
        return $this->chats;
    }

    public function addChat(Chat $chat): self
    {
        if (!$this->chats->contains($chat)) {
            $this->chats[] = $chat;
            $chat->setUser($this);
        }

        return $this;
    }

    public function removeChat(Chat $chat): self
    {
        if ($this->chats->contains($chat)) {
            $this->chats->removeElement($chat);
            // set the owning side to null (unless already changed)
            if ($chat->getUser() === $this) {
                $chat->setUser(null);
            }
        }

        return $this;
    }
}
