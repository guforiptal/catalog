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
    public function setUsername($username)
    {
        $this->username = $username;
        $this->usernameCanonical = $username;
        return $this;
    }
    public function setUsernameCanonical($usernameCanonical)
    {
        $this->usernameCanonical = $usernameCanonical;
        $this->username = $usernameCanonical;
        return $this;
    }
    public function setEmail($email)
    {
        $this->email = $email;
        $this->emailCanonical = $email;
        return $this;
    }
    public function setEmailCanonical($emailCanonical)
    {
        $this->emailCanonical = $emailCanonical;
        $this->email = $emailCanonical;
        return $this;
    }
    /**
     * Gets the last login time.
     *
     * @return string
     */
    public function getLastLogin()
    {
        if ($this->lastLogin != null)
            return $this->lastLogin->format('Y-m-d H:i:s');
        else
            return null;
    }
    /**
     * {@inheritdoc}
     */
    public function getRolesString()
    {
        $unique = $this->getRoles();
        $string = '';
        foreach ($unique as $role){
            $string .= $role . ' ';
        }
        return $string;
    }
    /**
     * Gets the timestamp that the user requested a password reset.
     *
     * @return null|\string
     */
    public function getPasswordRequestedAt()
    {
        if ($this->passwordRequestedAt != null)
            return $this->passwordRequestedAt->format('Y-m-d H:i:s');
        else
            return null;
    }
    public function getGetters()
    {
        $array = array();
        array_push($array,'getId');
        array_push($array,'getUsername');
        array_push($array,'getPassword');
        array_push($array,'getEmail');
        array_push($array,'getUsernameCanonical');
        array_push($array,'getEmailCanonical');
        array_push($array,'isEnabled');
        array_push($array,'getSalt');
        array_push($array,'getLastLogin');
        array_push($array,'getPasswordRequestedAt');
        array_push($array,'getRolesString');
        return $array;
    }
    public function eraseCredentials()
    {
    }
}