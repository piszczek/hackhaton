<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RestrictionRepository")
 */
class Restriction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Section", inversedBy="restrictions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $section;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $startAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $valueFrom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $valueTo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(?\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(?\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getValueFrom(): ?string
    {
        return $this->valueFrom;
    }

    public function setValueFrom(string $valueFrom): self
    {
        $this->valueFrom = $valueFrom;

        return $this;
    }

    public function getValueTo(): ?string
    {
        return $this->valueTo;
    }

    public function setValueTo(string $valueTo): self
    {
        $this->valueTo = $valueTo;

        return $this;
    }
}
