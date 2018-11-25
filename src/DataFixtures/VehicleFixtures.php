<?php

namespace App\DataFixtures;

use App\Entity\Enum\RestrictionType;
use App\Entity\Property;
use App\Entity\Route;
use App\Entity\Vehicle;
use App\Service\RouteResolver;
use App\Service\SectionResolver;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class VehicleFixtures extends Fixture
{
    /**
     * @var RouteResolver
     */
    private $routeResolver;
    /**
     * @var SectionResolver
     */
    private $sectionResolver;

    public function __construct(RouteResolver $routeResolver, SectionResolver $sectionResolver)
    {
        $this->routeResolver = $routeResolver;
        $this->sectionResolver = $sectionResolver;
    }

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

        $this->addRoutes($manager, $busVehicle);

    }


    public function addRoutes(ObjectManager $manager, Vehicle $vehicle)
    {
        $route = new Route();
        $route->setBlockTime(2);
        $route->setStartAt(new \DateTime());
        $route->setEndAt(new \DateTime());
        $route->setIsBlocking(false);
        $route->setVehicle($vehicle);

        $startPoint = $this->getReference('startPoint');
        $endPoint = $this->getReference('endPoint');

        $sections = $this->sectionResolver->resolve($route);

        $routeSections = $this->routeResolver->resolve($startPoint, $endPoint, $sections);

        $route->setSections($routeSections);

        $manager->persist($route);
        $manager->flush();
    }
}
