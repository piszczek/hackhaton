<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 *
 * @Table(name="point",
 *    uniqueConstraints={
 *        @UniqueConstraint(name="cords_unique",
 *            columns={"latitude", "longitude"})
 *    }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PointRepository")
 */
class Point
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $longitude;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $latitude;

//    /**
//     * @ORM\OneToMany(targetEntity="App\Entity\Section", mappedBy="startPoint", orphanRemoval=true)
//     */
//    private $sections;

    public function __construct()
    {
//        $this->sections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getId();
    }
}
