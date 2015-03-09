<?php

namespace Ico\Bundle\ParserBundle\Helpers;

use Doctrine\ORM\EntityManager;
use Exception;
use Ico\Bundle\ParserBundle\Interfaces\Truncator;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

/**
 * Truncate a table in the database from a class name by using doctrine reference
 */
class ClassTruncator implements Truncator {
    
    protected $em;
    
    public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
    }
    
    public function truncate($className) {
        
        if (!class_exists($className)) {
            throw new InvalidArgumentException('Vous devez spécifier un nom de Class valide.');
        }
        
        $cmd = $this->em->getClassMetadata($className);
        $connection = $this->em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->beginTransaction();
        
        try {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
            $q = $dbPlatform->getTruncateTableSql($cmd->getTableName(), true);
            $connection->executeUpdate($q);
            $connection->query('SET FOREIGN_KEY_CHECKS=1');
            $connection->commit();
            
        } catch (Exception $e) {
            $connection->rollback();
        }
        
    }
    
}
