<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mount
 *
 * @ORM\Table(name="mount")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MountRepository")
 */
class Mount
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
     * @var int
     *
     * @ORM\Column(name="movement", type="integer")
     */
    private $movement;

    /**
     * @var bool
     *
     * @ORM\Column(name="canFly", type="boolean")
     */
    private $canFly;


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
     * @return Mount
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
     * Set movement
     *
     * @param integer $movement
     *
     * @return Mount
     */
    public function setMovement($movement)
    {
        $this->movement = $movement;

        return $this;
    }

    /**
     * Get movement
     *
     * @return int
     */
    public function getMovement()
    {
        return $this->movement;
    }

    /**
     * Set canFly
     *
     * @param boolean $canFly
     *
     * @return Mount
     */
    public function setCanFly($canFly)
    {
        $this->canFly = $canFly;

        return $this;
    }

    /**
     * Get canFly
     *
     * @return bool
     */
    public function getCanFly()
    {
        return $this->canFly;
    }
}

