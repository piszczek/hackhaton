<?php

namespace App\Service;

use App\Entity\Enum\RestrictionType;
use App\Entity\Route;
use App\Entity\Section;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class SectionResolver
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Will find all valid section for given route
     *
     * todo: should not iterate over all routes (? should be do in some progressive more complicated way)
     *
     * @param Route $route
     * @return Collection
     */
    public function resolve(Route $route): Collection
    {
        $sections = $this->entityManager->getRepository(Section::class)->findAll();

        $vehicle = $route->getVehicle();

        $validSections = new ArrayCollection();
        foreach ($sections as $section) {
            foreach ($section->getRestrictions() as $restriction) {
                foreach ($vehicle->getProperties() as $property) {
                    if ($property->getType() === $restriction->getType()) {
                        //when restriction isn't pass
                        if ((int) $property->getValue() > (int) $restriction->getValueTo()) {
                            continue 3;
                        }
                    }
                }

                //when section isn't active
                if ($restriction->getType() === RestrictionType::TYPE_ACTIVE && (int) $restriction->getValueTo() !== 1) {
                    continue 2;
                }
            }

            $validSections->add($section);
        }

        return $validSections;
    }
}
