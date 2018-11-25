<?php

namespace App\Controller;

use App\Entity\Route;
use App\Form\RouteType;
use App\Repository\RouteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/route")
 */
class RouteController extends AbstractController
{
    /**
     * @Route("/", name="route_index", methods="GET")
     */
    public function index(RouteRepository $routeRepository): Response
    {
        return $this->render('route/index.html.twig', ['routes' => $routeRepository->findAll()]);
    }

    /**
     * @Route("/new", name="route_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $route = new Route();
        $form = $this->createForm(RouteType::class, $route);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($route);
            $em->flush();

            return $this->redirectToRoute('route_index');
        }

        return $this->render('route/new.html.twig', [
            'route' => $route,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="route_show", methods="GET")
     */
    public function show(Route $route): Response
    {
        return $this->render('route/show.html.twig', ['route' => $route]);
    }

    /**
     * @Route("/{id}/edit", name="route_edit", methods="GET|POST")
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
     * @Route("/{id}", name="route_delete", methods="DELETE")
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
}
