<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Item
 *
 * @ORM\Table(name="item")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ItemRepository")
 */
class Item
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var boolean
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;


    /**
     * @var string
     * @ORM\Column(name="description", type="string", length=255, unique=true)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(name="image", type="string", length=255, unique=true)
     */

    private $image;


    /**
     * @var int
     * @ORM\Column(name="category", type="integer")
     */
    private $category;

    /**
     * @var int
     * @ORM\Column(name="sku", type="integer")
     */
    private $sku;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Item
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set category
     *
     * @param int $category
     *
     * @return Item
     */

    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get item
     *
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Item
     */

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get item
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Item
     */

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set sku
     *
     * @param int $sku
     *
     * @return Item
     */

    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get sku
     *
     * @return int
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Item
     */

    public function setActive($active)
    {
        $this->sku = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }


}

