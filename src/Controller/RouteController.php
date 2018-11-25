<?php

namespace App\Controller;

use App\Entity\Route;
use App\Entity\Vehicle;
use App\Form\RouteType;
use App\Repository\RouteRepository;
use App\Repository\SectionRepository;
use App\Service\RouteResolver;
use App\Service\SectionResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route as RouteAnnotation;

/**
 * @RouteAnnotation("/route")
 */
class RouteController extends AbstractController
{
    /**
     * @var SectionResolver
     */
    private $sectionResolver;
    /**
     * @var RouteResolver
     */
    private $routeResolver;

    public function __construct(SectionResolver $sectionResolver, RouteResolver $routeResolver)
    {
        $this->sectionResolver = $sectionResolver;
        $this->routeResolver = $routeResolver;
    }

    /**
     * @RouteAnnotation("/", name="route_index", methods="GET")
     */
    public function index(RouteRepository $routeRepository): Response
    {
        return $this->render('route/index.html.twig', ['routes' => $routeRepository->findAll()]);
    }

    /**
     * @RouteAnnotation("/new/{vehicle}", name="route_new", methods="GET|POST")
     */
    public function new(Request $request, SectionRepository $sectionRepository, Vehicle $vehicle): Response
    {
        $route = new Route();
        $route->setVehicle($vehicle);

        $form = $this->createForm(RouteType::class, $route);
        $form->handleRequest($request);
        $sections = json_encode($sectionRepository->findAll());

        if ($form->isSubmitted() && $form->isValid()) {
            $startPoint = $form->get('startPoint')->getData();
            $endPoint = $form->get('endPoint')->getData();

            $sections = $this->sectionResolver->resolve($route);

            $routeSections = $this->routeResolver->resolve($startPoint, $endPoint, $sections);

            $route->setSections($routeSections);

            $em = $this->getDoctrine()->getManager();
            $em->persist($route);
            $em->flush();

            return $this->redirectToRoute('route_index');
        }

        return $this->render('route/new.html.twig', [
            'route' => $route,
            'form' => $form->createView(),
            'sections' => $sections
        ]);
    }

    /**
     * @RouteAnnotation("/{id}", name="route_show", methods="GET")
     */
    public function show(Route $route): Response
    {
        return $this->render('route/show.html.twig', ['route' => $route]);
    }

    /**
     * @RouteAnnotation("/{id}/edit", name="route_edit", methods="GET|POST")
     */
    public function edit(Request $request, Route $route): Response
    {
        $form = $this->createForm(RouteType::class, $route);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('route_index', ['id' => $route->getId()]);
        }

        return $this->render('route/edit.html.twig', [
            'route' => $route,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @RouteAnnotation("/{id}", name="route_delete", methods="DELETE")
     */
    public function delete(Request $request, Route $route): Response
    {
        if ($this->isCsrfTokenValid('delete'.$route->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($route);
            $em->flush();
        }

        return $this->redirectToRoute('route_index');
    }

    private function findPoints($data)
    {
        $startPoint = null;
        $endPoint = null;

        return [$startPoint, $endPoint];
    }
}
