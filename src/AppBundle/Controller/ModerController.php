<?php
/**
 * Created by PhpStorm.
 * User: DCP-ASUS
 * Date: 01.05.2017
 * Time: 22:48
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ModerController extends Controller
{
    /**
     * @Route("/moder", name="moder")
     */
    public function mainAction()
    {
        return $this->render('moder.html.twig');
    }

}