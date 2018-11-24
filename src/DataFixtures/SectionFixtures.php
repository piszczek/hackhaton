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

        $startPoint->setLatitude('52.6008266');
        $startPoint->setLongitude('19.6872685');

        $endPoint->setLatitude('52.6008481');
        $endPoint->setLongitude('19.686072');

        $section = new Section();
        $section->setName('A2');

        $section->setEndPoint($endPoint);
        $section->setStartPoint($startPoint);
        $section->setDistance(1231);

        $hightRestrction = new Restriction(RestrictionType::TYPE_HEIGHT);
        $hightRestrction->setValueTo("1999");
        $widthRestrion = new Restriction(RestrictionType::TYPE_WIDTH);
        $widthRestrion->setValueTo("231321");
        $weightRestrion = new Restriction(RestrictionType::TYPE_WEIGHT);
        $weightRestrion->setValueTo("12312");

        $activeRestriction = new Restriction(RestrictionType::TYPE_ACTIVE);
        $activeRestriction->setValueTo("1");


        $section->addRestriction($hightRestrction);
        $section->addRestriction($widthRestrion);
        $section->addRestriction($weightRestrion);
        $section->addRestriction($activeRestriction);

        $manager->persist($section);

        $manager->flush();
    }
}
