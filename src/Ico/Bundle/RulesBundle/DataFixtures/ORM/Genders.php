<?php

namespace Ico\Bundle\TrainingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ico\Bundle\RulesBundle\Entity\Gender;
//use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Genders implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {
    
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {
	   
	   $genders = array(
		  array(
			 'name' => 'Homme',
			 'short' => 'H',
            ),
		  array(
			 'name' => 'Femme',
			 'short' => 'F',
            ),
		  array(
			 'name' => 'Autre',
			 'short' => 'A',
            ),
	   );

	   foreach ($genders as $data) {
		  $gender = new Gender();
		  $gender->setName($data['name']);
		  $gender->setShort($data['short']);
		  $manager->persist($gender);
	   }
	   $manager->flush();
    }

    public function getOrder() {
	   return 15;
    }

}
