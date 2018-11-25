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
    public function resolve(Point $startPoint, Point $endPoint, Collection $sections): Collection
    {
        $routeSections = new ArrayCollection();
        //alghoritm to find valid route sections


        return $routeSections;
    }
}
