<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 12/23/16
 * Time: 6:49 AM
 */

namespace AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $objects = Fixtures::load(__DIR__.'/fixtures.yml', $manager, [
            'providers' => [$this]
        ]);
    }

    //public function unit(){
    //    $units = ['Unit 1'];
//
    //    $key = array_rand($units);
//
    //    return $units[$key];
    //}
}