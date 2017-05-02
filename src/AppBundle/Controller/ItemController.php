<?php
/**
 * Created by PhpStorm.
 * User: Влад
 * Date: 30.04.2017
 * Time: 20:51
 */

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ItemController extends Controller
{
    /**
     * @Route("/item/{id}", name = "item")
     */
    function itemAction($id)
    {
        $item = $this->getDoctrine()
            ->getRepository('AppBundle:Item')
            ->findOneById($id);

        $categories = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findAll();

        $current_category = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findOneById($item->getCategory());

        $category_view = $this->container->get('category_view');
        $receiving_breadcrumbs = $this->container->get('receiving_breadcrumbs');


        return $this->render('product.html.twig', array(
            'item'=>$item,
            'categories' => $category_view->getViewString($categories),
            'breadcrumbs' => $receiving_breadcrumbs->getViewString($current_category, $categories, ''),
        ));
    }


}