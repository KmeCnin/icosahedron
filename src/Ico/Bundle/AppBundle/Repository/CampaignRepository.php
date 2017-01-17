<?php

namespace Ico\Bundle\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Ico\Bundle\UserBundle\Entity\User;

class CampaignRepository extends EntityRepository
{
    public function findAllByPlayer(User $user)
    {
        return $this->createQueryBuilder('c')
            ->where('c.createdBy = :user')
            ->join('c.players', 'p')
            ->andWhere('p = :user')
            ->setParameters([
                'user' => $user,
            ])
            ->getQuery()
            ->getResult()
        ;
    }
}
