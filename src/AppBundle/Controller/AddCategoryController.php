<?php
/**
 * Created by PhpStorm.
 * User: Влад
 * Date: 01.05.2017
 * Time: 20:07
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class AddCategoryController extends Controller
{

    /**
     * @Route("/addCategory", name = "addCategory")
     */

    public function addProductAction()
    {
        return $this->render('addCategory.html.twig', array(
        ));
    }


}