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
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $alliance;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Faction", inversedBy="units")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $faction;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $minNumOfModels = 1;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $maxNumOfModels = 1;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $points;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $saveValue;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $braveryValue;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $numOfWounds = 1;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $spellsPerRound = 0;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
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

    public function getFaction()
    {
        return $this->faction;
    }

    public function setFaction(Faction $faction)
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