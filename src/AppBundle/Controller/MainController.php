<?php
/**
 * Created by PhpStorm.
 * User: Влад
 * Date: 29.04.2017
 * Time: 15:58
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MainController extends Controller
{
    /**
     * @Route("/main", name="main")
     */

    function mainAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('catalog');
        }

        return $this->render('main.html.twig');
    }
}