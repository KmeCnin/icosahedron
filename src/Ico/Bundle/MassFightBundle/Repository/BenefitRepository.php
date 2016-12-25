<?php

namespace Ico\Bundle\MassFightBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BenefitRepository extends EntityRepository
{
    public function findAlleles()
    {
        return $this->findBy(array('isAllele' => true));
    }
}
