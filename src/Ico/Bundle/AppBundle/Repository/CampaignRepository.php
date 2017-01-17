<?php

namespace Ico\Bundle\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Ico\Bundle\UserBundle\Entity\User;

class CampaignRepository extends EntityRepository
{
    public function findAllAs(User $user)
    {
        return $this->createQueryBuilder('c')
            ->where('c.createdBy = :user')
            ->leftJoin('c.players', 'p')
            ->orWhere('p = :user')
            ->setParameters([
                'user' => $user,
            ])
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneAs(int $id, User $user)
    {
        return $this->createQueryBuilder('c')
            ->where('c.createdBy = :user')
            ->leftJoin('c.players', 'p')
            ->orWhere('p = :user')
            ->setParameters([
                'user' => $user,
            ])
            ->getQuery()
            ->getResult()
        ;
    }
}
