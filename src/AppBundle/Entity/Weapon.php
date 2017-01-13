<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 12/24/16
 * Time: 7:32 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="weapon")
 * @UniqueEntity(fields={"weaponName"}, message="This weapon already exists")
 */
class Weapon
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $weaponName;
    /**
     * @ORM\Column(type="smallint")
     */
    private $minRange = 0;
    /**
     * @ORM\Column(type="smallint")
     */
    private $maxRange;
    /**
     * @ORM\Column(type="smallint")
     */
    private $attacks = 1;
    /**
     * @ORM\Column(type="smallint")
     */
    private $toHit;
    /**
     * @ORM\Column(type="smallint")
     */
    private $toWound;
    /**
     * @ORM\Column(type="string", columnDefinition="enum('melee', 'ranged')")
     */
    private $weaponType;

    /**
     * @ORM\Column(type="string", columnDefinition="enum('dice', 'static')")
     */
    private $dmgDeterminer;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $numberOfDmgDice;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $maxDieDmgValue;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $staticDmg;
    
    

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getWeaponName()
    {
        return $this->weaponName;
    }

    /**
     * @param mixed $weaponName
     */
    public function setWeaponName($weaponName)
    {
        $this->weaponName = $weaponName;
    }

    /**
     * @return mixed
     */
    public function getMinRange()
    {
        return $this->minRange;
    }

    /**
     * @param mixed $minRange
     */
    public function setMinRange($minRange)
    {
        $this->minRange = $minRange;
    }

    /**
     * @return mixed
     */
    public function getMaxRange()
    {
        return $this->maxRange;
    }

    /**
     * @param mixed $maxRange
     */
    public function setMaxRange($maxRange)
    {
        $this->maxRange = $maxRange;
    }

    /**
     * @return mixed
     */
    public function getAttacks()
    {
        return $this->attacks;
    }

    /**
     * @param mixed $attacks
     */
    public function setAttacks($attacks)
    {
        $this->attacks = $attacks;
    }

    /**
     * @return mixed
     */
    public function getToHit()
    {
        return $this->toHit;
    }

    /**
     * @param mixed $toHit
     */
    public function setToHit($toHit)
    {
        $this->toHit = $toHit;
    }

    /**
     * @return mixed
     */
    public function getToWound()
    {
        return $this->toWound;
    }

    /**
     * @param mixed $toWound
     */
    public function setToWound($toWound)
    {
        $this->toWound = $toWound;
    }

    /**
     * @return mixed
     */
    public function getWeaponType()
    {
        return $this->weaponType;
    }

    /**
     * @param mixed $weaponType
     */
    public function setWeaponType($weaponType)
    {
        $this->weaponType = $weaponType;
    }

    /**
     * @return mixed
     */
    public function getDmgDeterminer()
    {
        return $this->dmgDeterminer;
    }

    /**
     * @param mixed $dmgDeterminer
     */
    public function setDmgDeterminer($dmgDeterminer)
    {
        $this->dmgDeterminer = $dmgDeterminer;
    }

    /**
     * @return mixed
     */
    public function getNumberOfDmgDice()
    {
        return $this->numberOfDmgDice;
    }

    /**
     * @param mixed $numberOfDmgDice
     */
    public function setNumberOfDmgDice($numberOfDmgDice)
    {
        $this->numberOfDmgDice = $numberOfDmgDice;
    }

    /**
     * @return mixed
     */
    public function getMaxDieDmgValue()
    {
        return $this->maxDieDmgValue;
    }

    /**
     * @param mixed $maxDieDmgValue
     */
    public function setMaxDieDmgValue($maxDieDmgValue)
    {
        $this->maxDieDmgValue = $maxDieDmgValue;
    }

    /**
     * @return mixed
     */
    public function getStaticDmg()
    {
        return $this->staticDmg;
    }

    /**
     * @param mixed $staticDmg
     */
    public function setStaticDmg($staticDmg)
    {
        $this->staticDmg = $staticDmg;
    }
}