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
use Doctrine\ORM\Tools\Pagination\Paginator;
use AppBundle\Entity\User;
use Symfony\Component\Debug\Debug;


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
        $grid_service = $this->container->get('app.grid_service');
        $grid_service->setBundleName('AppBundle:User');
        $grid_service->setPost($_POST);
        $response = $grid_service->getGrid();

        header("Content-type: text/xml;charset=utf-8");
        return new Response($response);
    }

    /**
     * @Route("/admin/users/edit", name="users_edit")
     */
    public function usersActionEdit()
    {
        $grid_service = $this->container->get('app.grid_service');
        $grid_service->setBundleName('AppBundle:User');
        $grid_service->setPost($_POST);


        return new Response();
    }

    private function getColumnName()
    {
        return array_keys($_POST)[0];
    }

    private function printArray($array)
    {
        foreach ($array as $key => $value) {
            file_put_contents("php://stdout", "\n$key => $value" . var_dump($_POST));
            if (is_array($value)) {
                $this->printArray($value);
            }
        }
    }

    private function caseCorrector($str)
    {
        switch($str){
            case('usernamecanonical'):
                return 'usernameCanonical';
            case('emailcanonical'):
                return 'emailCanonical';
            case('lastlogin'):
                return 'lastLogin';
            case('confirmationtoken'):
                return 'confirmationToken';
            case('passwordrequestedat'):
                return 'passwordRequestedAt';
        }
        return $str;
    }
}