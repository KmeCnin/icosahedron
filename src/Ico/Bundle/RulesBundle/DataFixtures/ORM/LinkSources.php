<?php

namespace Ico\Bundle\TrainingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ico\Bundle\RulesBundle\Entity\LinkSource;

class LinkSources implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
	   
	   $sources = array(
		  array(
			 'domain' => 'www.pathfinder-fr.org',
			 'name' => 'Wiki Pathfinder',
			 'language' => 'fr',
			 'picture' => 'pathfinder-fr.jpg'
		  ),
		  array(
			 'domain' => 'www.regles-pathfinder.fr',
			 'name' => 'Documents de Référence Pathfinder (BlackBook)',
			 'language' => 'fr',
			 'picture' => 'blackbook.gif'
		  ),
		  array(
			 'domain' => 'www.black-book-editions.fr',
			 'name' => 'Page de téléchargement (BlackBook)',
			 'language' => 'fr',
			 'picture' => 'blackbook.gif'
		  ),
		  array(
			 'domain' => 'paizo.com',
			 'name' => 'Pathfinder Reference Document (Paizo)',
			 'language' => 'en',
			 'picture' => 'paizo.gif'
		  ),
	   );

	   foreach ($sources as $data) {
		  $source = new LinkSource();
		  $source->setDomain($data['domain']);
		  $source->setName($data['name']);
		  $source->setLanguage($data['language']);
		  $source->setPicture($data['picture']);
		  $manager->persist($source);
	   }
	   $manager->flush();
    }

    public function getOrder() {
	   return 10;
    }

}
