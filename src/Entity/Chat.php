<?php

namespace App\Entity;

<<<<<<< HEAD
use App\Repository\ChatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChatRepository::class)
=======
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ChatRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ChatRepository::class)
 *  @ApiResource( 
 * 
 * attributes={
 *      "security" = "(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM') or is_granted('ROLE_APPRENANT'))",
 *      "security_message" = "vous n'avez pas accès a cette resource"
 * },
 * 
 * collectionOperations={
 * 
 *      "show_chat_apprenant_promo"={
 *          "method"= "GET",
 *          "path" = "/users/promo/{id1}/apprenant/{id2}/chats",
 *          "route_name"="getChatOfOneApprenantOfOnePromo",
 *      },
 * 
 *     "creat_chat_apprenant_promo"={
 *          "method"= "POST",
 *          "path" = "/users/promo/{id1}/apprenant/{id2}/chats",
 *          "route_name"="postChatOfOneApprenantOfOnePromo",
 *      }
 * },
 * itemOperations={
 * "get"={
 * 
 * }
 * }
 * )
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
 */
class Chat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
<<<<<<< HEAD
=======
     * Groups({"chat_apprenant:read"})
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
<<<<<<< HEAD
=======
     * Groups({"chat_apprenant:read"})
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=255)
<<<<<<< HEAD
=======
     * Groups({"chat_apprenant:read"})
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
     */
    private $pieceJointe;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="chat")
<<<<<<< HEAD
=======
     * Groups({"chat_apprenant:read"})
>>>>>>> 20c9996cae5c860e55ffc7778283aebfabad698d
     */
    private $promo;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="chats")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getPieceJointe(): ?string
    {
        return $this->pieceJointe;
    }

    public function setPieceJointe(string $pieceJointe): self
    {
        $this->pieceJointe = $pieceJointe;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
