<?php

namespace Ico\Bundle\MassFightBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TacticRepository extends EntityRepository
{
    public function findDefaults()
    {
        return $this->findBy([
            'isDefault' => true,
        ]);
    }
}
