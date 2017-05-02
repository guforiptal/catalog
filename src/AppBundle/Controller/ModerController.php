<?php
/**
 * Created by PhpStorm.
 * User: DCP-ASUS
 * Date: 01.05.2017
 * Time: 22:48
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ModerController extends Controller
{
    /**
     * @Route("/moder", name="moder")
     */
    public function mainAction()
    {
        return $this->render('moder.html.twig');
    }

    /**
     * @Route("/moder/items", name="items")
     */
    public function itemsActionShow()
    {
        $grid = $this->gridInit('AppBundle:Item', $_POST);
        $response = $grid->getGrid();

        header("Content-type: text/xml;charset=utf-8");
        return new Response($response);
    }

    /**
     * @Route("/moder/items/edit", name="items_edit")
     */
    public function itemsActionEdit()
    {
        $grid = $this->gridInit('AppBundle:Item', $_POST);
        $grid->editGrid();

        return new Response();
    }

    private function gridInit($bundle_name,$post)
    {
        $grid_service = $this->container->get('app.grid_service');
        $grid_service->setBundleName($bundle_name);
        $grid_service->setPost($post);
        return $grid_service;
    }

}