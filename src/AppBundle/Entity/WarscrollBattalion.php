<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WarscrollBattalion
 *
 * @ORM\Table(name="warscroll_battalion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WarscrollBattalionRepository")
 */
class WarscrollBattalion
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
     * @ORM\Column(name="additionalPoints", type="smallint")
     */
    private $additionalPoints;


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
     * @return WarscrollBattalion
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
     * Set additionalPoints
     *
     * @param integer $additionalPoints
     *
     * @return WarscrollBattalion
     */
    public function setAdditionalPoints($additionalPoints)
    {
        $this->additionalPoints = $additionalPoints;

        return $this;
    }

    /**
     * Get additionalPoints
     *
     * @return int
     */
    public function getAdditionalPoints()
    {
        return $this->additionalPoints;
    }
}

