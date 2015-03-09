<?php

namespace Ico\Bundle\ParserBundle\Helpers;

use Doctrine\ORM\EntityManager;
use Ico\Bundle\ParserBundle\Interfaces\Truncator;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

/**
 * Truncate a table in the database from the table name
 */
class TableTruncator implements Truncator {
    
    protected $em;
    
    public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
    }
    
    public function truncate($tableName) {
        
        $schemaManager = $this->em->getConnection()->getSchemaManager();
        if ($schemaManager->tablesExist(array($tableName)) != true) {
            throw new InvalidArgumentException('Vous devez spécifier un nom de table valide.');
        }
        $query = 'TRUNCATE TABLE `' . $tableName . '`';
        $stmt = $this->em->getConnection()->prepare($query);
        $stmt->execute();
        
    }
    
}
