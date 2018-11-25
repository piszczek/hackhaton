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
        $points = [];
        $collector = [];
        $sections = $this->getSections();

        foreach ($sections as $sect) {


            if (!isset($collector[(string)$sect['startPoint'][0]])) {
                $startPoint = new Point();
                $startPoint->setLatitude($sect['startPoint'][0]);
                $startPoint->setLongitude($sect['startPoint'][1]);

                $collector[(string)$sect['startPoint'][0]] = $startPoint;
                $points[] = $sect['startPoint'][0];
            }
            else {
                $startPoint = $collector[(string)$sect['startPoint'][0]];
            }

            if (!isset($collector[(string)$sect['endPoint'][0]])) {
                $endPoint = new Point();
                $endPoint->setLatitude($sect['endPoint'][0]);
                $endPoint->setLongitude($sect['endPoint'][1]);

                $collector[(string)$sect['endPoint'][0]] = $endPoint;
                $points[] = $sect['endPoint'][0];
            }
            else {
                $endPoint = $collector[(string)$sect['endPoint'][0]];
            }

            $section = new Section();
            $section->setName(rand(0,10000));

            $section->setStartPoint($startPoint);
            $section->setEndPoint($endPoint);
            $section->setDistance($this->calcDistance($sect['startPoint'][0], $sect['startPoint'][1], $sect['endPoint'][0], $sect['endPoint'][1]));

            $heightRestriction = new Restriction(RestrictionType::TYPE_HEIGHT);
            $heightRestriction->setValueTo("999");

            $widthRestriction = new Restriction(RestrictionType::TYPE_WIDTH);
            $widthRestriction->setValueTo("999");

            $weightRestriction = new Restriction(RestrictionType::TYPE_WEIGHT);
            $weightRestriction->setValueTo("999");

            $activeRestriction = new Restriction(RestrictionType::TYPE_ACTIVE);
            $activeRestriction->setValueTo("1");

            $section->addRestriction($heightRestriction);
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
            ['startPoint' => [52.6002693,19.6865978], 'endPoint' => [52.6002661,19.6874437]],
            ['startPoint' => [52.6002661,19.6874437], 'endPoint' => [52.5997192,19.6874445]],
            ['startPoint' => [52.6002661,19.6874437], 'endPoint' => [52.6002364,19.689552]],
            ['startPoint' => [52.6002364,19.689552], 'endPoint' => [52.6001573,19.6940927]],
            ['startPoint' => [52.5986896,19.6881822], 'endPoint' => [52.5986704,19.6897351]],
            ['startPoint' => [52.6001573,19.6940927], 'endPoint' => [52.5986171,19.6940817]],
            ['startPoint' => [52.5986704,19.6897351], 'endPoint' => [52.5986699,19.6916248]],
            ['startPoint' => [52.5986699,19.6916248], 'endPoint' => [52.5986386,19.692788]],
            ['startPoint' => [52.5986386,19.6927880], 'endPoint' => [52.5986171,19.6940816]],
            ['startPoint' => [52.6002364,19.6895520], 'endPoint' => [52.5999466,19.6895444]],
            ['startPoint' => [52.5999466,19.6895444], 'endPoint' => [52.5992987,19.6895111]],
            ['startPoint' => [52.5992987,19.6895111], 'endPoint' => [52.599152,19.6897478]],
            ['startPoint' => [52.599152,19.6897477], 'endPoint' => [52.5986704,19.6897351]],
            ['startPoint' => [52.5999466,19.6895443], 'endPoint' => [52.5999144,19.6917446]],
            ['startPoint' => [52.599152,19.6897477], 'endPoint' => [52.5991328,19.69170439]],
            ['startPoint' => [52.5999144,19.6917445], 'endPoint' => [52.5991328,19.69170439]],
            ['startPoint' => [52.5991328,19.6917043], 'endPoint' => [52.5986699,19.6916248]],
            ['startPoint' => [52.5999144,19.6917445], 'endPoint' => [52.5998865,19.6928158]],
            ['startPoint' => [52.5998865,19.6928158], 'endPoint' => [52.599125,19.6927942]],
            ['startPoint' => [52.5991328,19.6917043], 'endPoint' => [52.599125,19.6927941]],
            ['startPoint' => [52.599125,19.6927941], 'endPoint' => [52.5986386,19.6927880]]
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
