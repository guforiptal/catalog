<?php
/**
 * Created by PhpStorm.
 * User: Влад
 * Date: 01.05.2017
 * Time: 19:49
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AddProductController extends Controller
{

    /**
     * @Route("/addProduct", name = "addProduct")
     */

    public function addProductAction()
    {
        return $this->render('addProduct.html.twig', array(
        ));
    }

}