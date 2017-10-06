<?php
/**
 * Created by PhpStorm.
 * User: timbauer
 * Date: 7/6/17
 * Time: 8:26 PM
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class UnitRepository extends EntityRepository
{
    public function findBySearchTerm($searchTerm){
        $searchTerm = '%' . $searchTerm . '%';
        return $this->createQueryBuilder('aos_unit')
            ->andWhere('aos_unit.name LIKE :name')
            ->setParameter('name', $searchTerm)
            ->getQuery()
            ->execute()
        ;
    }
}