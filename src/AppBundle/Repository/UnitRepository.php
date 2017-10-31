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
            ->join('aos_unit.faction', 'faction', 'WITH', 'aos_unit.faction = faction.id')
            ->join('aos_unit.alliance', 'alliance', 'WITH', 'aos_unit.alliance = alliance.id')
            ->Where('aos_unit.name LIKE :searchTerm 
                    OR aos_unit.description LIKE :searchTerm
                    OR faction.name LIKE :searchTerm
                    OR alliance.name LIKE :searchTerm')
            ->setParameter('searchTerm', $searchTerm)
            ->getQuery()
            ->execute()
        ;
    }
}