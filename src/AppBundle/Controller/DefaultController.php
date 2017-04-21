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
    * @Route("/main", name="main")
    */
    public function mainAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('login');
        }
        return $this->render('main.html.twig');
    }

    /**
     * @Route("/register", name="register")
     */
    public function registeRedirect()
    {
        return $this->redirectToRoute('registration');
    }
}