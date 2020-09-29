<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait ResourceId{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"article:read", "article:details_read", "user_read", "user_details_read"})
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

}