<?php

namespace App\Service;

use App\Entity\Point;
use App\Entity\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


class RouteResolver
{
    /**
     *
     * @param Route $route
     * @return Collection
     */
    public function resolve(Point $startPoint, Point $endPoint, Collection $sections): array
    {
        $routeSections = [];

        $graph =[];
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

        $algorithm = new \Fisharebest\Algorithm\Dijkstra($graph);
        $path = $algorithm->shortestPaths($startPoint->getId(), $endPoint->getId());

        $tuples = $this->listToTuples($path);

//        TODO: w tym momencie mamy zwroconą tablicę z krotkami [startPoint, endPoint]

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
