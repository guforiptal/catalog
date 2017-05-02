<?php
/**
 * Created by PhpStorm.
 * User: Влад
 * Date: 02.05.2017
 * Time: 13:41
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RoleEditController extends Controller
{
    /**
     * @Route("/editRole/{id}/{role}", name="edit_role")
     */
    public function editRoleAction($id, $role)
    {

        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findOneById($id);
        $user->addRole($role);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('main');
    }
}