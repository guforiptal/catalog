<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 26.04.2017
 * Time: 12:24
 */
namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function mainAction()
    {
        return $this->render('admin.html.twig');
    }
    /**
     * @Route("/admin/users", name="users")
     */
    public function usersActionShow()
    {
        $grid = $this->gridInit('AppBundle:User', $_POST);
        $response = $grid->getGrid();
        header("Content-type: text/xml;charset=utf-8");
        return new Response($response);
    }
    /**
     * @Route("/admin/users/edit", name="users_edit")
     */
    public function usersActionEdit()
    {
        $grid = $this->gridInit('AppBundle:User', $_POST);
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