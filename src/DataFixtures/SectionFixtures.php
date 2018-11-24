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
        $sections = $this->getSections();

        foreach ($sections as $section) {


            $startPoint = $manager->getRepository(Point::class)->findByCords($section['startPoint'][0], $section['startPoint'][1]);
            if (!$startPoint) {
                $startPoint = new Point();
                $startPoint->setLatitude($section['startPoint'][0]);
                $startPoint->setLongitude($section['startPoint'][1]);
            }

            $endPoint = $manager->getRepository(Point::class)->findByCords($section['endPoint'][0], $section['endPoint'][1]);
            if (!$endPoint) {
                $endPoint = new Point();
                $endPoint->setLongitude($section['endPoint'][0]);
                $endPoint->setLatitude($section['endPoint'][1]);
            }


            $section = new Section();
            $section->setName(rand(0,1000));

            $section->setStartPoint($startPoint);
            $section->setEndPoint($endPoint);
            $section->setDistance($this->calcDistance($section['startPoint'][0], $section['startPoint'][1], $section['endPoint'][0], $section['endPoint'][1]));

            $hightRestrction = new Restriction(RestrictionType::TYPE_HEIGHT);
            $hightRestrction->setValueTo("999");
            $widthRestriction = new Restriction(RestrictionType::TYPE_WIDTH);
            $widthRestriction->setValueTo("999");
            $weightRestriction = new Restriction(RestrictionType::TYPE_WEIGHT);
            $weightRestriction->setValueTo("999");
            $weightRestriction = new Restriction(RestrictionType::TYPE_WEIGHT);
            $weightRestriction->setValueTo("999");
            $activeRestriction = new Restriction(RestrictionType::TYPE_WEIGHT);
            $activeRestriction->setValueTo("1");

            $section->addRestriction($hightRestrction);
            $section->addRestriction($widthRestriction);
            $section->addRestriction($weightRestriction);
            $section->addRestriction($activeRestriction);

            $manager->persist($section);

            $manager->flush();
        }
    }

    private function getSections()
    {
        $sections = [
            ['startPoint' => [52.6008266,19.6872685], 'endPoint' => [52.6008481,19.686072]],
            ['startPoint' => [52.6008481,19.686072], 'endPoint' => [52.6007922,19.6854842]],
            ['startPoint' => [52.6007922,19.6854842], 'endPoint' => [52.6000353,19.685292]],
            ['startPoint' => [52.6000353,19.685292], 'endPoint' => [52.6000239,19.6862196]],
            ['startPoint' => [52.6000121,19.6865964], 'endPoint' => [52.6000353,19.685292]],
            ['startPoint' => [52.6008481,19.686072], 'endPoint' => [52.6000239,19.6862196]],
            ['startPoint' => [52.6000239,19.6862196], 'endPoint' => [52.5991507,19.6861345]],
            ['startPoint' => [52.5991507,19.6861345], 'endPoint' => [52.5987211,19.6861228]],
            ['startPoint' => [52.5987211,19.6861228], 'endPoint' => [52.5987308,19.686890]],
            ['startPoint' => [52.5987308,19.6868890], 'endPoint' => [52.5986896,19.6881822]],
            ['startPoint' => [52.6000121,19.6865963], 'endPoint' => [52.6002693,19.6865978]],
            ['startPoint' => [52.6002693,19.6865978], 'endPoint' => [52.6002661,19.6874437]]
        ];

        return $sections;
    }

    public function calcDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return (int)($angle * $earthRadius);
    }
}
