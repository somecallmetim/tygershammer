<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 12/23/16
 * Time: 5:09 AM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FactionRepository")
 * @ORM\Table(name="faction")
 * @UniqueEntity(fields={"name"}, message="This Unit already exists")
 */
class FactionEntity
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
    private $name;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    function __toString()
    {
        return $this->name;
    }


}