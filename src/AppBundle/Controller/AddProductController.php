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
use AppBundle\Entity\Item;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class AddProductController extends Controller
{

    /**
     * @Route("/addProduct", name = "addProduct")
     */

    public function addProductAction(Request $request)
    {
        $item = new Item();

        $form = $this->createFormBuilder($item)
            ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('description', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('image', UrlType::class, array('attr' => array('class' => 'form-control')))
            ->add('category', IntegerType::class, array('attr' => array('class' => 'form-control')))
            ->add('sku', IntegerType::class, array('attr' => array('class' => 'form-control')))
            ->add('save', SubmitType::class, array('label' => 'Add item',
                                                    'attr' => array('class' => 'btn btn-default btn-block')
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('main');
        }

        return $this->render('addProduct.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}