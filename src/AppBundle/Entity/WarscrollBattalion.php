<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * WarscrollBattalion
 *
 * @ORM\Table(name="warscroll_battalion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WarscrollBattalionRepository")
 * @UniqueEntity(fields={"name"}, message="This Battalion already exists")
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
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="additionalPointCost", type="integer")
     * @Assert\NotBlank()
     */
    private $additionalPointCost;


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
     * Set additionalPointCost
     *
     * @param integer $additionalPointCost
     *
     * @return WarscrollBattalion
     */
    public function setAdditionalPointCost($additionalPointCost)
    {
        $this->additionalPointCost = $additionalPointCost;

        return $this;
    }

    /**
     * Get additionalPointCost
     *
     * @return int
     */
    public function getAdditionalPointCost()
    {
        return $this->additionalPointCost;
    }
}

