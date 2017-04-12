<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 1/13/17
 * Time: 9:31 AM
 */

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FactionRepository")
 * @ORM\Table(name="faction")
 * @UniqueEntity(fields={"name"}, message="This Faction already exists")
 */
class Faction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Unit", mappedBy="faction")
     */
    private $units;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Alliance", inversedBy="factions")
     */
    private $alliance;

    public function __construct()
    {
        $this->units = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getUnits()
    {
        return $this->units;
    }

    /**
     * @param mixed $units
     */
    public function setUnits($units)
    {
        $this->units = $units;
    }

    /**
     * @return mixed
     */
    public function getAlliance()
    {
        return $this->alliance;
    }

    /**
     * @param mixed $alliance
     */
    public function setAlliance($alliance)
    {
        $this->alliance = $alliance;
    }

    function __toString()
    {
        return $this->name;
    }


}