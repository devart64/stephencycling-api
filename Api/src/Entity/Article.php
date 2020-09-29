<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ApiResource(
 *     collectionOperations={
 *         "get"={
 *             "normalization_context"={"groups"={"article:read"}}
 *         }
 *     },
 *     itemOperations={
 *         "get"={
 *             "normalization_context"={"groups"={"article:details_read"}}
 *         }
 *     }
 * )
 */
class Article
{
    use ResourceId;
    use Timestampable;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_details_read", "article:read", "article:details_read"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups({"user_details_read", "article:read", "article:details_read"})
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"article:details_read"})
     */
    private $author;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
