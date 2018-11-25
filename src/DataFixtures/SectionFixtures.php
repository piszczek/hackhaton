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

                if (!$this->hasReference('startPoint')) {
                    $this->setReference('startPoint', $startPoint);
                }
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

                $this->setReference('endPoint', $endPoint);
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
            ['startPoint' => [52.6008266,19.6872685],'endPoint' => [52.6008481,19.686072]],
            ['startPoint' => [52.6008481,19.686072],'endPoint' => [52.6007922,19.6854842]],
            ['startPoint' => [52.6007922,19.6854842],'endPoint' => [52.6000353,19.685292]],
            ['startPoint' => [52.6000353,19.685292],'endPoint' => [52.6000239,19.6862196]],
            ['startPoint' => [52.6000121,19.6865964],'endPoint' => [52.6000353,19.685292]],
            ['startPoint' => [52.6008481,19.686072],'endPoint' => [52.6000239,19.6862196]],
            ['startPoint' => [52.6000239,19.6862196],'endPoint' => [52.5991507,19.6861345]],
            ['startPoint' => [52.5991507,19.6861345],'endPoint' => [52.5987211,19.6861228]],
            ['startPoint' => [52.5987211,19.6861228],'endPoint' => [52.5987308,19.686890]],
            ['startPoint' => [52.5987308,19.6868890],'endPoint' => [52.5986896,19.6881822]],
            ['startPoint' => [52.6000121,19.6865963],'endPoint' => [52.6002693,19.6865978]],
            ['startPoint' => [52.6002693,19.6865978],'endPoint' => [52.6002661,19.6874437]],
            ['startPoint' => [52.6002661,19.6874437],'endPoint' => [52.5997192,19.6874445]],
            ['startPoint' => [52.6002661,19.6874437],'endPoint' => [52.6002364,19.689552]],
            ['startPoint' => [52.6002364,19.689552],'endPoint' => [52.6001573,19.6940927]],
            ['startPoint' => [52.5986896,19.6881822],'endPoint' => [52.5986704,19.6897351]],
            ['startPoint' => [52.6001573,19.6940927],'endPoint' => [52.5986171,19.6940817]],
            ['startPoint' => [52.5986704,19.6897351],'endPoint' => [52.5986699,19.6916248]],
            ['startPoint' => [52.5986699,19.6916248],'endPoint' => [52.5986386,19.692788]],
            ['startPoint' => [52.5986386,19.6927880],'endPoint' => [52.5986171,19.6940816]],
            ['startPoint' => [52.6002364,19.6895520],'endPoint' => [52.5999466,19.6895444]],
            ['startPoint' => [52.5999466,19.6895444],'endPoint' => [52.5992987,19.6895111]],
            ['startPoint' => [52.5992987,19.6895111],'endPoint' => [52.599152,19.6897478]],
            ['startPoint' => [52.599152,19.6897477],'endPoint' => [52.5986704,19.6897351]],
            ['startPoint' => [52.5999466,19.6895443],'endPoint' => [52.5999144,19.6917446]],
            ['startPoint' => [52.599152,19.6897477],'endPoint' => [52.5991328,19.69170439]],
            ['startPoint' => [52.5999144,19.6917445],'endPoint' => [52.5991328,19.69170439]],
            ['startPoint' => [52.5991328,19.6917043],'endPoint' => [52.5986699,19.6916248]],
            ['startPoint' => [52.5999144,19.6917445],'endPoint' => [52.5998865,19.6928158]],
            ['startPoint' => [52.5998865,19.6928158],'endPoint' => [52.599125,19.6927942]],
            ['startPoint' => [52.5991328,19.6917043],'endPoint' => [52.599125,19.6927941]],
            ['startPoint' => [52.599125,19.6927941],'endPoint' => [52.5986386,19.6927880]],
            ['startPoint' => [52.5987211,19.6861228],'endPoint' => [52.5973565,19.6860841]],
            ['startPoint' => [52.5973565,19.6860841],'endPoint' => [52.5973419,19.6880943]],
            ['startPoint' => [52.5973419,19.6880943],'endPoint' => [52.597313,19.6897064]],
            ['startPoint' => [52.597313,19.6897064],'endPoint' => [52.5972426,19.6938688]],
            ['startPoint' => [52.5986896,19.6881822],'endPoint' => [52.5973419,19.6880942]],
            ['startPoint' => [52.5986704,19.6897351],'endPoint' => [52.597313,19.6897063]],
            ['startPoint' => [52.5986171,19.6940816],'endPoint' => [52.5972426,19.6938688]],
            ['startPoint' => [52.5973565,19.6860841],'endPoint' => [52.5971785,19.6860393]],
            ['startPoint' => [52.5971785,19.6860393],'endPoint' => [52.5958874,19.6860023]],
            ['startPoint' => [52.5958874,19.6860023],'endPoint' => [52.5957662,19.693815]],
            ['startPoint' => [52.5972426,19.6938688],'endPoint' => [52.5957662,19.6938149]],
            ['startPoint' => [52.5958874,19.6860022],'endPoint' => [52.5960888,19.6687275]],
            ['startPoint' => [52.5960888,19.6687275],'endPoint' => [52.5961967,19.6628552]],
            ['startPoint' => [52.5961967,19.6628552],'endPoint' => [52.5962804,19.6569729]],
            ['startPoint' => [52.5962804,19.6569729],'endPoint' => [52.5948302,19.6568838]],
            ['startPoint' => [52.5948302,19.6568838],'endPoint' => [52.5927353,19.6568149]],
            ['startPoint' => [52.5927353,19.6568149],'endPoint' => [52.5912377,19.6567616]],
            ['startPoint' => [52.5912377,19.6567616],'endPoint' => [52.5894975,19.6567105]],
            ['startPoint' => [52.5894975,19.6567105],'endPoint' => [52.5884263,19.6566697]],
            ['startPoint' => [52.5884263,19.6566697],'endPoint' => [52.5883419,19.6625595]],
            ['startPoint' => [52.5883419,19.6625595],'endPoint' => [52.588245,19.6684677]],
            ['startPoint' => [52.588245,19.6684677],'endPoint' => [52.588196,19.6733258]],
            ['startPoint' => [52.588196,19.6733258],'endPoint' => [52.5880801,19.6792407]],
            ['startPoint' => [52.5880801,19.6792407],'endPoint' => [52.5879743,19.6857651]],
            ['startPoint' => [52.5879743,19.6857651],'endPoint' => [52.5878831,19.6936576]],
            ['startPoint' => [52.5878831,19.6936576],'endPoint' => [52.5906699,19.6936318]],
            ['startPoint' => [52.5906699,19.6936318],'endPoint' => [52.5908551,19.6859417]],
            ['startPoint' => [52.5908551,19.6859417],'endPoint' => [52.590916,19.679333]],
            ['startPoint' => [52.590916,19.679333],'endPoint' => [52.5910034,19.6734592]],
            ['startPoint' => [52.5910034,19.6734592],'endPoint' => [52.5910898,19.6685805]],
            ['startPoint' => [52.5910898,19.6685805],'endPoint' => [52.5911541,19.6626757]],
            ['startPoint' => [52.5912377,19.6567615],'endPoint' => [52.5911541,19.6626757]],
            ['startPoint' => [52.5883419,19.6625595],'endPoint' => [52.5911541,19.6626757]],
            ['startPoint' => [52.5910898,19.6685804],'endPoint' => [52.588245,19.6684677]],
            ['startPoint' => [52.5910898,19.6685804],'endPoint' => [52.588245,19.6684677]],
            ['startPoint' => [52.5910034,19.6734592],'endPoint' => [52.588196,19.6733257]],
            ['startPoint' => [52.590916,19.679333],'endPoint' => [52.5880801,19.6792407]],
            ['startPoint' => [52.5908551,19.6859417],'endPoint' => [52.5879743,19.6857651]],
            ['startPoint' => [52.5957662,19.6938149],'endPoint' => [52.5906699,19.6936318]],
            ['startPoint' => [52.5961967,19.6628551],'endPoint' => [52.5911541,19.6626757]],
            ['startPoint' => [52.5960888,19.6687274],'endPoint' => [52.5910898,19.6685804]],
            ['startPoint' => [52.5958874,19.6860022], 'endPoint' => [52.5908551,19.6859417]],
            ['startPoint' => [52.5884263,19.6566697],'endPoint' => [52.5789507,19.656295]],
            ['startPoint' => [52.5789507,19.656295],'endPoint' => [52.5786361,19.6788977]],
            ['startPoint' => [52.5786361,19.6788977],'endPoint' => [52.576019,19.6787364]],
            ['startPoint' => [52.576019,19.6787364],'endPoint' => [52.5758347,19.6934446]],
            ['startPoint' => [52.5878831,19.6936576],'endPoint' => [52.5758347,19.6934446]],
            ['startPoint' => [52.5880801,19.6792407],'endPoint' => [52.5786361,19.6788976]]
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
