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
use AppBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AddCategoryController extends Controller
{

    /**
     * @Route("/addCategory", name = "addCategory")
     */

    public function addProductAction(Request $request)
    {
        $item = new Category();

        $form = $this->createFormBuilder($item)
            ->add('name', TextType::class)
            ->add('parent', IntegerType::class)
            ->add('save', SubmitType::class, array('label' => 'Add category'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('main');
        }

        return $this->render('addCategory.html.twig', array(
            'form' => $form->createView(),
        ));
    }


}