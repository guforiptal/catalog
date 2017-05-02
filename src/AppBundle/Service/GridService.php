<?php

namespace AppBundle\Service;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;

class GridService
{
    private $bundle_name = '';
    private $post = [];
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function setBundleName($bundle_name)
    {
        $this->bundle_name = $bundle_name;
    }

    public function setPost(&$post)
    {
        $this->post = $post;
    }

    public function getGrid()
    {
        $page = $this->post['page'];
        $limit = $this->post['rows'];
        $sidx = $this->post['sidx'];
        $sord = $this->post['sord'];
        if (!$sidx) $sidx = 1;

        $start = $limit * $page - $limit;
        if ($start < 0) $start = 0;

        $repository = $this->em->getRepository($this->bundle_name);

        $query = $repository->createQueryBuilder('u')
            ->orderBy('u.'.$this->caseCorrector($sidx), strtoupper($sord))
            ->getQuery()
            ->setFirstResult($start)
            ->setMaxResults($limit);

        $count = $this->em->createQuery(
            'SELECT COUNT(u)
    FROM '.$this->bundle_name.' u'
        )->getSingleScalarResult();

        if ($count > 0 && $limit > 0) {
            $total_pages = ceil($count / $limit);
        } else {
            $total_pages = 0;
        }

        $s = "<?xml version='1.0' encoding='utf-8'?>";
        $s .= "<rows>";
        $s .= "<page>" . $page . "</page>";
        $s .= "<total>" . $total_pages . "</total>";
        $s .= "<records>" . $count . "</records>";

        $paginator = new Paginator($query, $fetchJoinCollection = true);

        foreach ($paginator as $object) {
            $s .= "<row id='" . $object->getId() . "'>";
            $this->printArray($object->getGetters());
            foreach ($object->getGetters() as $getter) {
                if($object->$getter() != null)
                    $s .= "<cell>" . $object->$getter() . "</cell>";
                else
                    $s .= "<cell>" . 'N/A' . "</cell>";
            }
            $s .= "</row>";
        }
        $s .= "</rows>";

        return $s;
    }

    public function editGrid()
    {
        $id = $this->post['id'];
        $column_name = $this->getColumnName();
        $value = $this->post[$column_name];

        $repository = $this->em->getRepository($this->bundle_name);
        $object = $repository->findOneById($id);

        $setter_name = 'set'.ucfirst($this->caseCorrector($column_name));
        $object->$setter_name($value);

        $this->em->persist($object);
        $this->em->flush();

        return;
    }

    private function getColumnName()
    {
        return array_keys($_POST)[0];
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

    private function printArray($array)
    {
        foreach ($array as $key => $value) {
            file_put_contents("php://stdout", "\n$key => $value");
            if (is_array($value)) {
                $this->printArray($value);
            }
        }
    }
}