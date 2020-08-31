<?php

namespace App\Entity;

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
 */
class Chat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * Groups({"chat_apprenant:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * Groups({"chat_apprenant:read"})
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=255)
     * Groups({"chat_apprenant:read"})
     */
    private $pieceJointe;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="chat")
     * Groups({"chat_apprenant:read"})
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
