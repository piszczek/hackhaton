<?php

namespace App\DataFixtures;

use App\Entity\Enum\RestrictionType;
use App\Entity\Point;
use App\Entity\Restriction;
use App\Entity\Section;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SectionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $startPoint = new Point();
        $endPoint = new Point();

        $startPoint->setLatitude('999');
        $startPoint->setLongitude('999');

        $endPoint->setLongitude('999');
        $endPoint->setLatitude('99');


        $section = new Section();
        $section->setName('A2');

        $section->setEndPoint($endPoint);
        $section->setStartPoint($startPoint);

        $hightRestrction = new Restriction(RestrictionType::TYPE_HEIGHT);
        $hightRestrction->setValueTo("1999");
        $widthRestrion = new Restriction(RestrictionType::TYPE_WIDTH);
        $widthRestrion->setValueTo("231321");
        $weightRestrion = new Restriction(RestrictionType::TYPE_WEIGHT);
        $weightRestrion->setValueTo("12312");


        $section->addRestriction($hightRestrction);
        $section->addRestriction($widthRestrion);
        $section->addRestriction($weightRestrion);

        $manager->persist($section);

        $manager->flush();
    }
}