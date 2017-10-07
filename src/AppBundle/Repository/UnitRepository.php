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
            ->Where('aos_unit.name LIKE :searchTerm 
                    OR aos_unit.description LIKE :searchTerm')
            ->setParameter('searchTerm', $searchTerm)
            ->getQuery()
            ->execute()
        ;
    }
}