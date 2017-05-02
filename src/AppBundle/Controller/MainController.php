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

        $items = $this->getDoctrine()
            ->getRepository('AppBundle:Item')
            ->findAll();

        return $this->render('main.html.twig', array(
            'image1' => $items['1']->getImage(),
            'image2' => $items['2']->getImage(),
            'image3' => $items['3']->getImage(),
        ));
    }
}