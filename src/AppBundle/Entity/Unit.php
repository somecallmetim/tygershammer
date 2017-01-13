<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 12/9/16
 * Time: 3:24 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Entity\Faction;

/**
 * @ORM\Entity
 * @ORM\Table(name="unit")
 * @UniqueEntity(fields={"name"}, message="This Unit already exists")
 */
class Unit
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Faction")
     * @ORM\JoinColumn(nullable=false)
     */
    private $faction;

    /**
     * @ORM\Column(type="smallint")
     */
    private $minNumOfModels = 1;

    /**
     * @ORM\Column(type="smallint")
     */
    private $maxNumOfModels = 1;

    /**
     * @ORM\Column(type="smallint")
     */
    private $points;

    /**
     * @ORM\Column(type="smallint")
     */
    private $saveValue;

    /**
     * @ORM\Column(type="smallint")
     */
    private $braveryValue;

    /**
     * @ORM\Column(type="smallint")
     */
    private $numOfWounds = 1;

    /**
     * @ORM\Column(type="smallint")
     */
    private $spellsPerRound = 0;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getFaction()
    {
        return $this->faction;
    }

    public function setFaction($faction)
    {
        $this->faction = $faction;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getMinNumOfModels()
    {
        return $this->minNumOfModels;
    }

    public function setMinNumOfModels($minNumOfModels)
    {
        $this->minNumOfModels = $minNumOfModels;
    }

    public function getMaxNumOfModels()
    {
        return $this->maxNumOfModels;
    }

    public function setMaxNumOfModels($maxNumOfModels)
    {
        $this->maxNumOfModels = $maxNumOfModels;
    }

    public function getPoints()
    {
        return $this->points;
    }

    public function setPoints($points)
    {
        $this->points = $points;
    }

    public function getSaveValue()
    {
        return $this->saveValue;
    }

    public function setSaveValue($saveValue)
    {
        $this->saveValue = $saveValue;
    }

    public function getBraveryValue()
    {
        return $this->braveryValue;
    }

    public function setBraveryValue($braveryValue)
    {
        $this->braveryValue = $braveryValue;
    }

    public function getNumOfWounds()
    {
        return $this->numOfWounds;
    }

    public function setNumOfWounds($numOfWounds)
    {
        $this->numOfWounds = $numOfWounds;
    }

    public function getSpellsPerRound()
    {
        return $this->spellsPerRound;
    }

    public function setSpellsPerRound($spellsPerRound)
    {
        $this->spellsPerRound = $spellsPerRound;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
}