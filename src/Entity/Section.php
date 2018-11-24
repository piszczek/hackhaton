<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SectionRepository")
 */
class Section
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Point")
     * @ORM\JoinColumn(nullable=false)
     */
    private $startPoint;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Point")
     * @ORM\JoinColumn(nullable=false)
     */
    private $endPoint;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Restriction", mappedBy="section", orphanRemoval=true)
     */
    private $restrictions;

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

    public function addProperty(Restriction $restriction): self
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
}
