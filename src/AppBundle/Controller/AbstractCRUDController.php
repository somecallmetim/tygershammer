<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 1/15/17
 * Time: 8:57 AM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\AbstractCRUDEntity;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class AbstractCRUDController extends Controller
{

    protected $routes = array();
    protected $twigForm;
    protected $entityName;
    protected $serializer;

    abstract function setRoutes();

    function __construct()
    {
        $this->setRoutes();
    }
}