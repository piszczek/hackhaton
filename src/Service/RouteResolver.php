<?php

namespace App\Service;

use App\Entity\Point;
use App\Entity\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\SectionRepository;
use Fisharebest\Algorithm\Dijkstra;


class RouteResolver
{
    protected $sectionRepo;

    public function __construct(SectionRepository $sectionRepo)
    {
        $this->sectionRepo = $sectionRepo;
    }

    /**
     *
     * @param Route $route
     * @return Collection
     */
    public function resolve(Point $startPoint, Point $endPoint, $sections): array
    {
        $routeSections = [];

        $graph = [];
        foreach ($sections as $segment) {
            if (!array_key_exists($segment->getStartPoint()->getId(), $graph)) {
                $graph[$segment->getStartPoint()->getId()] = [];
            }

            if (!array_key_exists($segment->getEndPoint()->getId(), $graph)) {
                $graph[$segment->getEndPoint()->getId()] = [];
            }

            $graph[$segment->getStartPoint()->getId()][$segment->getEndPoint()->getId()] = $segment->getDistance();
            $graph[$segment->getEndPoint()->getId()][$segment->getStartPoint()->getId()] = $segment->getDistance();
        }

        $algorithm = new Dijkstra($graph);
        $path = $algorithm->shortestPaths($startPoint->getId(), $endPoint->getId());

        $tuples = $this->listToTuples($path[0]);

        foreach ($tuples as $tuple) {
            $sectionObj = $this->sectionRepo->findOneBy(['startPoint' => $tuple[0], 'endPoint' => $tuple[1]]);
            if(is_null($sectionObj)) {
                $sectionObj = $this->sectionRepo->findOneBy(['startPoint' => $tuple[1], 'endPoint' => $tuple[0]]);
            }
            array_push($routeSections, $sectionObj);
        }

        return $routeSections;
    }

    private function listToTuples(array $list): array
    {
        $array = [];
        for ($i = 0; $i < count($list) - 1; $i++) {
            $array[] = [$list[$i], $list[$i+1]];
        }

        return $array;
    }
}
