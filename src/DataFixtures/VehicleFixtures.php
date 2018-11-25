<?php

namespace App\DataFixtures;

use App\Entity\Enum\RestrictionType;
use App\Entity\Property;
use App\Entity\Vehicle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class VehicleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        foreach (['Transport osobowy', 'Transport gabarytowy'] as $name) {

            $busVehicle = new Vehicle();
            $busVehicle->setName($name);

            $heightProperty = new Property();
            $heightProperty->setType(RestrictionType::TYPE_HEIGHT);
            $heightProperty->setValue("250");

            $widthProperty = new Property();
            $widthProperty->setType(RestrictionType::TYPE_WIDTH);
            $widthProperty->setValue("250");

            $weightProperty = new Property();
            $weightProperty->setType(RestrictionType::TYPE_WEIGHT);
            $weightProperty->setValue("250");

            $busVehicle
                ->addProperty($widthProperty)
                ->addProperty($heightProperty)
                ->addProperty($weightProperty);

            $manager->persist($busVehicle);
        }
        $manager->flush();
    }
}
