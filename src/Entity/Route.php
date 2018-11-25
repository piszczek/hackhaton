<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RouteRepository")
 */
class Route implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Vehicle")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicle;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Section")
     */
    private $sections;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isBlocking;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $blockTime;

    public function __construct()
    {
        $this->sections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): self
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * @return Collection|Section[]
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(Section $section): self
    {
        if (!$this->sections->contains($section)) {
            $this->sections[] = $section;
        }

        return $this;
    }

    public function removeSection(Section $section): self
    {
        if ($this->sections->contains($section)) {
            $this->sections->removeElement($section);
        }

        return $this;
    }

    public function getIsBlocking(): ?bool
    {
        return $this->isBlocking;
    }

    public function setIsBlocking(bool $isBlocking): self
    {
        $this->isBlocking = $isBlocking;

        return $this;
    }

    public function getBlockTime(): ?int
    {
        return $this->blockTime;
    }

    public function setBlockTime(?int $blockTime): self
    {
        $this->blockTime = $blockTime;

        return $this;
    }

    public function setSections(Collection $routeSections): self
    {
        $this->sections = $routeSections;

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
        $sections = [];

        foreach ($this->getSections() as $section) {
            $sections[] = $section->jsonSerialize();
        }

        return [
          'id' => $this->getId(),
          'vehicle' => [
              'id' => $this->getVehicle()->getId(),
              'type' => $this->getVehicle()->getType(),
              'name' => $this->getVehicle()->getName(),
          ],
           'sections' => $sections
        ];
    }
}
