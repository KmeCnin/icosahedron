<?php

namespace Ico\Bundle\ParserBundle\Services;

use Ico\Bundle\ParserBundle\Helpers\ClassTruncator;

class TruncatorManager {

    protected $em;
    
    public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
    }
    
    /**
     * Renvoi un objet Truncator correspondant à l'input envoyé (nom de table ou nom de classe)
     * 
     * return Truncator
     */
    public function getTruncator($target) {
        
        if (class_exists($target)) {
            // Truncator à partir du nom de la classe
            return new ClassTruncator($this->em);
            
        } else {
            
            $schemaManager = $this->em->getConnection()->getSchemaManager();
            if ($schemaManager->tablesExist(array($target)) == true) {
                // Truncator à partir du nom de la table
                return new TableTruncator($this->em);
            } else {
                // input non valide
                throw new InvalidArgumentException('Vous devez spécifier un nom de Class valide ou un nom de table valide.');
            }
            
        }
	
        
    }

}
