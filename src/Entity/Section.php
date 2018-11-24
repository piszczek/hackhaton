<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SectionRepository")
 */
class Section implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Point", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $startPoint;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Point", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $endPoint;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Restriction", mappedBy="section", orphanRemoval=true,cascade={"persist"})
     */
    private $restrictions;

    /**
     * @ORM\Column(type="integer")
     */
    private $distance;

    public function __construct()
    {
        $this->restrictions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStartPoint(): ?Point
    {
        return $this->startPoint;
    }

    public function setStartPoint(?Point $startPoint): self
    {
        $this->startPoint = $startPoint;

        return $this;
    }

    public function getEndPoint(): ?Point
    {
        return $this->endPoint;
    }

    public function setEndPoint(?Point $endPoint): self
    {
        $this->endPoint = $endPoint;

        return $this;
    }

    /**
     * @return Collection|Restriction[]
     */
    public function getRestrictions(): Collection
    {
        return $this->restrictions;
    }

    public function addRestriction(Restriction $restriction): self
    {
        if (!$this->restrictions->contains($restriction)) {
            $this->restrictions[] = $restriction;
            $restriction->setSection($this);
        }

        return $this;
    }

    public function removeRestriction(Restriction $restriction): self
    {
        if ($this->restrictions->contains($restriction)) {
            $this->restrictions->removeElement($restriction);
            // set the owning side to null (unless already changed)
            if ($restriction->getSection() === $this) {
                $restriction->setSection(null);
            }
        }

        return $this;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'startPoint' => [
                'lat' => (float) $this->getStartPoint()->getLatitude(),
                'lng' => (float) $this->getStartPoint()->getLongitude(),
            ],
            'endPoint' => [
                'lat' => (float) $this->getEndPoint()->getLatitude(),
                'lng' => (float) $this->getEndPoint()->getLongitude(),
            ]
        ];
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }
}
