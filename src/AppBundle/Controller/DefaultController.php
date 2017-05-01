<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="root")
     */
    public function rootAction()
    {
        return $this->redirectToRoute('main');
    }

    /**
     * @Route("/catalog", name="catalog")
     */
    public function catalogAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('main');
        }

        $categories = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findAll();

        $items = $this->getDoctrine()
            ->getRepository('AppBundle:Item')
            ->findAll();

        $category_view = $this->container->get('category_view');
        $items_view = $this->container->get('items_on_category_view');


        return $this->render('catalog.html.twig', array(
            'categories' => $category_view->getViewString($categories),
            'items' =>$items_view->getViewString($items),
        ));
    }


    /**
     * @Route("/catalog/category/{category}", name="category")
     */
    public function categoryAction($category)
    {
        $categories = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findAll();

        $items = $this->getDoctrine()
            ->getRepository('AppBundle:Item')
            ->findByCategory($category);


        $category_view = $this->container->get('category_view');
        $items_view = $this->container->get('items_on_category_view');
        //$paginator = $this->get('knp_paginator');


        return $this->render('catalog.html.twig', array(
            'categories' => $category_view->getViewString($categories),
            'items' =>$items_view->getViewString($items),
        ));
    }

}