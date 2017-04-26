<?php
/**
 * Created by PhpStorm.
 * User: DCP-ASUS
 * Date: 12.04.2017
 * Time: 17:03
 */

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="app_users")
 * @ORM\Entity()
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    protected $plainPassword;

    public function __construct()
    {
        parent::__construct();
        $this->enabled = true;
    }

    public function getSalt()
    {
        return null;
    }

    public function setRoleUser()
    {
        $this->addRole("ROLE_USER");
        if ($this->username == "admin"){
            $this->addRole("ROLE_ADMIN");
        }
    }

    public function eraseCredentials()
    {
    }

}