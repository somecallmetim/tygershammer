<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 1/19/17
 * Time: 9:42 PM
 */

namespace AppBundle\Service;

use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializerBuilder;

class EntitySerializer
{
    function __construct()
    {
        $this->serializer = SerializerBuilder::create()
            ->setPropertyNamingStrategy(new SerializedNameAnnotationStrategy(new IdenticalPropertyNamingStrategy()))
            ->build();
    }

    public function buildAttributeArray($entity){
        return $this->serializer->toArray($entity);
    }
}