<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AbilityEntity
 *
 * @ORM\Table(name="ability")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AbilityEntityRepository")
 */
class AbilityEntity
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
     * @return AbilityEntity
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
     * @return AbilityEntity
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
     * @return AbilityEntity
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

