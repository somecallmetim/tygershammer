<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UnitAbility
 *
 * @ORM\Table(name="unit_ability")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UnitAbilityRepository")
 */
class UnitAbility
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
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="commandAbility", type="boolean")
     */
    private $commandAbility;


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
     * @return UnitAbility
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
     * Set description
     *
     * @param string $description
     *
     * @return UnitAbility
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set commandAbility
     *
     * @param boolean $commandAbility
     *
     * @return UnitAbility
     */
    public function setCommandAbility($commandAbility)
    {
        $this->commandAbility = $commandAbility;

        return $this;
    }

    /**
     * Get commandAbility
     *
     * @return bool
     */
    public function getCommandAbility()
    {
        return $this->commandAbility;
    }
}

