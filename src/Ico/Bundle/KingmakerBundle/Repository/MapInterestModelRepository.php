<?php

namespace Ico\Bundle\KingmakerBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * MapInterestModelRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MapInterestModelRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }
}
