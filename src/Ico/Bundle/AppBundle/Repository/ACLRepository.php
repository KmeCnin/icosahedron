<?php

namespace Ico\Bundle\AppBundle\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

abstract class ACLRepository extends EntityRepository
{
    protected $authorizationChecker;

    public function __construct(
        EntityManager $em,
        Mapping\ClassMetadata $class,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        parent::__construct($em, $class);
        $this->authorizationChecker = $authorizationChecker;
    }
}
