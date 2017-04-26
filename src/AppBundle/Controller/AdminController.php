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
    public function usersAction()
    {
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        if (!$sidx) $sidx = 1;

        $start = $limit * $page - $limit;
        if($start < 0) $start = 0;

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT u
    FROM AppBundle:User u
    ORDER BY u.'.$this->caseCorrector($sidx).' '.strtoupper($sord)
        )->setFirstResult($start)->setMaxResults($limit);

        $count = $em->createQuery(
            'SELECT COUNT(u)
    FROM AppBundle:User u'
        )->getSingleScalarResult();

        if( $count > 0 && $limit > 0) {
            $total_pages = ceil($count/$limit);
        } else {
            $total_pages = 0;
        }

        header("Content-type: text/xml;charset=utf-8");

        $s = "<?xml version='1.0' encoding='utf-8'?>";
        $s .= "<rows>";
        $s .= "<page>" . $page . "</page>";
        $s .= "<total>" . $total_pages . "</total>";
        $s .= "<records>" . $count . "</records>";

        $paginator = new Paginator($query, $fetchJoinCollection = true);

        foreach ($paginator as $user) {
            $s .= "<row id='" . $user->getId() . "'>";
            $s .= "<cell>" . $user->getId() . "</cell>";
            $s .= "<cell>" . $user->getUsername() . "</cell>";
            $s .= "<cell>" . $user->getPassword() . "</cell>";
            $s .= "<cell>" . $user->getEmail() . "</cell>";
            $s .= "<cell>" . $user->getUsernameCanonical() . "</cell>";
            $s .= "<cell>" . $user->getEmailCanonical() . "</cell>";
            $s .= "<cell>" . $user->isEnabled() . "</cell>";
            $s .= "<cell>" . $user->getSalt() . "</cell>";
            if($user->getLastLogin() != null)  $s .= "<cell>" . $user->getLastLogin()->format('Y-m-d H:i:s') . "</cell>";
            else $s .= "<cell>" . 'N/A' . "</cell>";
            $s .= "<cell>" . $user->getConfirmationToken() . "</cell>";
            if($user->getPasswordRequestedAt() != null)   $s .= "<cell>" . $user->getPasswordRequestedAt()->format('Y-m-d H:i:s')->toString() . "</cell>";
            else $s .= "<cell>" . 'N/A' . "</cell>";
            $roles = "";
            foreach ($user->getRoles() as $str){
                $roles .= $str . ' ';
            }
            $s .= "<cell>" . $roles . "</cell>";
            $s .= "</row>";
        }
        $s .= "</rows>";
        return new Response($s);
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