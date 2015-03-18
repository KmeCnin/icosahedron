<?php

namespace Ico\Bundle\ParserBundle\Services;

use Ico\Bundle\ParserBundle\Interfaces\DatabaseFormater;

class DatabaseExporter {

    protected $em;
    protected $databaseFormater;
    protected $entities;
    protected $bundle;
    
    public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
        $this->bundle = 'IcoRulesBundle';
    }
    
    /**
     * Défini un objet en charge de formater les données issues de la BDD.
     * Il doit s'agir d'un objet qui extends l'interface DatabaseFormater
     * 
     * @param DatabaseFormater $databaseFormater
     */
    public function setDatabaseFormater(DatabaseFormater $databaseFormater) {
	   $this->databaseFormater = $databaseFormater;
    }
    
    public function export() {
	   foreach($this->entities as $entity) {
		  $repository = $this->getDoctrine()->getRepository($this->bundle.':'.$entity);
		  $entries = $repository->findAll();
		  $this->databaseFormater->format($entries);
	   }
    }
    
    /**
     * @param array $entities
     * @throws InvalidArgumentException
     */
    public function setEntities($entities) {
	   if (!is_array($entities)) {
		  throw new InvalidArgumentException('Vous devez fournir un Array de namespaces d\'Entity en paramètre.');
	   }
	   foreach($entities as $entity) {
		  if (!$this->isEntity($entity)) {
			 throw new InvalidArgumentException('Au moins une des valeurs entrées en paramètre de votre Array n\'est pas un namespace d\'Entité Doctrine.');
		  }
	   }
	   $this->entities = $entities;
    }
    
    /**
     * @param string $entity
     * @throws InvalidArgumentException
     */
    public function addEntity($entity) {
	   if (!$this->isEntity($entity)) {
		  throw new InvalidArgumentException('Vous devez entrer un namespace d\'Entité Doctrine valide.');
	   }
	   $this->entities[] = $entity;
    }
    
    /**
     * Détermine si le namespace entré correspond à une entité Doctrine
     * 
     * @param string $entity
     * @return boolean
     */
    protected function isEntity($entity) {
	   $meta = $this->em->getMetadataFactory()->getMetadataFor($entity);
	   return $this->em->getMetadataFactory()->isEntity($meta);
    }

}
