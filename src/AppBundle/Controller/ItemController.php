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
            ->findById($id);

        $categories = $this->getDoctrine()
            ->getRepository('AppBundle:Category')
            ->findAll();

        $item_view = $this->container->get('item_view');
        $category_view = $this->container->get('category_view');

        $item = $item_view->itemToArray($item);

        return $this->render('product.html.twig', array(
            'item'=>$item,
            'categories' => $category_view->getViewString($categories),
        ));
    }


}