<?php

namespace Kiwi\Bundle\TrainingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ico\Bundle\RulesBundle\Entity\SavingThrow;

class SavingThrows implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
	   $savingthrows = array(
		  array(
			 'name_id' => 'reflex',
			 'name' => 'Réflexes',
			 'short' => 'Réf',
			 'description' => 'Ce type de jet de sauvegarde représente la faculté du personnage à esquiver les attaques de zone et les situations inattendues. On y applique le modificateur de Dextérité.'
		  ),
		  array(
			 'name_id' => 'fortitude',
			 'name' => 'Vigueur',
			 'short' => 'Vig',
			 'description' => 'Ce type de jet de sauvegarde reflète la capacité du personnage à résister aux attaques mettant sa vitalité ou sa santé en danger, ainsi qu’à résister à la douleur. On y applique le modificateur de Constitution.'
		  ),
		  array(
			 'name_id' => 'will',
			 'name' => 'Volonté',
			 'short' => 'Vol',
			 'description' => 'Ce type de jet de sauvegarde représente la faculté du personnage à se soustraire aux tentatives de domination et à d’autres effets magiques similaires. On y ajoute le modificateur de Sagesse.'
		  )
	   );

	   foreach ($savingthrows as $data) {
		  $savingthrow = new SavingThrow();
		  $savingthrow->setNameId($data['name_id']);
		  $savingthrow->setName($data['name']);
		  $savingthrow->setShort($data['short']);
		  $savingthrow->setDescription($data['description']);
		  $manager->persist($savingthrow);
	   }
	   $manager->flush();
    }

    public function getOrder() {
	   return 7;
    }

}
