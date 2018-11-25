<?php

namespace App\Entity;

use App\Entity\Enum\RestrictionType;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RestrictionRepository")
 */
class Restriction implements \JsonSerializable
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Section", inversedBy="restrictions", cascade={"persist"})
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $valueFrom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $valueTo;

    public function __construct(int $type)
    {
        $this->type = $type;
    }

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
          'label' => $this->getLabel(),
          'type' => $this->getType(),
          'valueTo' => $this->getValueTo()
        ];
    }

    private function getLabel(): string
    {
        switch ($this->getType()) {
            case RestrictionType::TYPE_WEIGHT:
                return 'Waga';
            case RestrictionType::TYPE_WIDTH:
                return 'Szerokość';
            case RestrictionType::TYPE_HEIGHT:
                return 'Wysokość';
            case RestrictionType::TYPE_ACTIVE:
                return 'Active/Inactive';

        }

        return 'unknown';
    }
}
