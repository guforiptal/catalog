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
use Symfony\Component\Debug\Debug;


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
    public function usersActionShow()
    {
        $page = $_POST['page'];
        $limit = $_POST['rows'];
        $sidx = $_POST['sidx'];
        $sord = $_POST['sord'];
        if (!$sidx) $sidx = 1;

        $start = $limit * $page - $limit;
        if ($start < 0) $start = 0;

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT u
    FROM AppBundle:User u
    ORDER BY u.' . $this->caseCorrector($sidx) . ' ' . strtoupper($sord)
        )->setFirstResult($start)->setMaxResults($limit);

        $count = $em->createQuery(
            'SELECT COUNT(u)
    FROM AppBundle:User u'
        )->getSingleScalarResult();

        if ($count > 0 && $limit > 0) {
            $total_pages = ceil($count / $limit);
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
            if ($user->getLastLogin() != null) $s .= "<cell>" . $user->getLastLogin()->format('Y-m-d H:i:s') . "</cell>";
            else $s .= "<cell>" . 'N/A' . "</cell>";
            $s .= "<cell>" . $user->getConfirmationToken() . "</cell>";
            if ($user->getPasswordRequestedAt() != null) $s .= "<cell>" . $user->getPasswordRequestedAt()->format('Y-m-d H:i:s') . "</cell>";
            else $s .= "<cell>" . 'N/A' . "</cell>";
            $roles = "";
            foreach ($user->getRoles() as $str) {
                $roles .= $str . ' ';
            }
            $s .= "<cell>" . $roles . "</cell>";
            $s .= "</row>";
        }
        $s .= "</rows>";
        return new Response($s);
    }

    /**
     * @Route("/admin/users/edit", name="users_edit")
     */
    public function usersActionEdit()
    {
        $id = $_POST['id'];
        $column_name = $this->getColumnName();
        $value = $_POST[$column_name];

        //file_put_contents("php://stdout", "\nDump:");
        //$this->printArray(array_keys($_POST));

        $repository = $this->getDoctrine()->getRepository('AppBundle:User');
        $user = $repository->findOneById($id);

        $setter_name = 'set'.ucfirst($this->caseCorrector($column_name));
        $user->$setter_name($value);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new Response();
    }

    private function getColumnName()
    {
        return array_keys($_POST)[0];
    }

    private function printArray($array)
    {
        foreach ($array as $key => $value) {
            file_put_contents("php://stdout", "\n$key => $value" . var_dump($_POST));
            if (is_array($value)) {
                $this->printArray($value);
            }
        }
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