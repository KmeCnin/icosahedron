<?php

namespace Ico\Bundle\ParserBundle\Services;

use Ico\Bundle\ParserBundle\Services\DatabaseFormater;

class DatabaseExporter {

    protected $em;
    protected $entities;
    protected $bundle;
    protected $databaseFormater;
    
    public function __construct(EntityManager $entityManager, DatabaseFormater $databaseFormater) {
        $this->em = $entityManager;
        $this->databaseFormater = $databaseFormater;
        $this->setBundle('IcoRulesBundle');
    }
    
    public function export($format = DatabaseFormater::XML) {
	   $this->databaseFormater->setFormat($format);
	   foreach($this->entities as $entity) {
		  $repository = $this->getDoctrine()->getRepository($this->bundle.':'.$entity);
		  $entries = $repository->findAll();
		  $entries_converted = $this->databaseFormater->convert($entries);
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
    
    /**
     * @param string $bundle
     */
    public function setBundle(EncoderInterface $bundle) {
	   if (!array_key_exists($bundle, $this->container->getParameter('kernel.bundles'))) {
		  throw new InvalidArgumentException('Le bundle '.$bundle.' n\'éxiste pas.');
	   }
	   $this->bundle = $bundle;
    }
}
