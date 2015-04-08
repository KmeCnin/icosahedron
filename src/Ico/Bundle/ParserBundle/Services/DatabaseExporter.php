<?php

namespace Ico\Bundle\ParserBundle\Services;
//use Symfony\Component\Serializer\Encoder\EncoderInterface;
//use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


use Doctrine\ORM\EntityManager;
use Ico\Bundle\ParserBundle\Services\DatabaseFormater;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Exception\InvalidArgumentException;
use Symfony\Component\Filesystem\Filesystem;

class DatabaseExporter {

    protected $em;
    protected $entities; // List de tous les namespaces des entités à exporter
    protected $allExistingBundles;
    protected $databaseFormater;
    
    public $path;
    
    public function __construct(EntityManager $entityManager, DatabaseFormater $databaseFormater, ContainerInterface $container) {
        $this->em = $entityManager;
	   $databaseFormater->setFormat(DatabaseFormater::FORMAT_DEFAULT);
        $this->databaseFormater = $databaseFormater;
	   $this->entities = $container->getParameter('ico.parser.services.database_exporter.entities');
        $this->path = 'web/Database/';
	   unset($container);
    }
    
    /**
     * 
     * @param string $format
     */
    public function export($format = DatabaseFormater::FORMAT_DEFAULT) {
	   $filesystem = new Filesystem();
	   foreach($this->entities as $entity) {
		  $repository = $this->em->getRepository($entity);
		  $entries = $repository->findAll();
		  $root = $this->path.(new \ReflectionClass($entries[0]))->getShortName();
		  print '	'.$entity.'
';
		  foreach($entries as $entry) {
			 $path = $root.'/'.$entry->getSlug().'.'.$format;
			 $data = $this->databaseFormater->convert($entry);
			 $filesystem->dumpFile($path, $data); 
			 print '	   '.$entry->getSlug().'
';
		  }
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
	   $object = new $entity();
	   return method_exists($object, 'getSlug');
//	   $meta = $this->em->getMetadataFactory()->getMetadataFor($entity);
//	   $isEntity = $this->em->getMetadataFactory()->isEntity($meta);
//	   if ($isEntity) {
//		  $object = new $entity();
//		  if (method_exists($object, 'getSlug')) {
//			 return true;
//		  }
//	   }
//	   return false;
    }
    
    /**
     * 
     * @return array
     */
    public function getEntities() {
	   return $this->entities;
    }
    
    protected function namespaceFromBundle($bundle) {
	   return 'Ico\Bundle\\'.$bundle.'\\';
    }
    
    /**
     * 
     * @param string $path
     */
    public function setPath($path) {
	   $this->path = $path;
    }
}
