<?php

namespace Ico\Bundle\TrainingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ico\Bundle\RulesBundle\Entity\BattleRange;

class BattleRanges implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
	   
	   $ranges = array(
		  array(
			 'nameId' => 'personal',
			 'name' => 'Personnelle',
			 'description' => "Le sort n'affecte que son lanceur."
		  ),
		  array(
			 'nameId' => 'touch',
			 'name' => 'Contact',
			 'description' => "Il faut toucher une créature ou un objet pour l'affecter. Un sort de contact qui inflige des dégâts peut se transformer en coup critique, comme n'importe quelle arme. Un tel sort a une chance d'asséner un coup critique sur un 20 naturel et inflige deux fois plus de dégâts en cas de confirmation. Certains sorts de contact permettent de toucher plusieurs cibles. Le personnage peut toucher jusqu'à six cibles consentantes lors de son incantation mais il doit toutes les toucher au cours du round pendant lequel il termine son incantation. Si le sort permet de le faire sur plusieurs rounds, le fait de toucher les six créatures devient une action complexe."
		  ),
		  array(
			 'nameId' => 'close',
			 'name' => 'Courte',
			 'description' => "Le sort peut agir à une distance maximale de 7,50 m (5 cases), plus 1,50 m (1 case) tous les deux niveaux de lanceur de sorts."
		  ),
		  array(
			 'nameId' => 'medium',
			 'name' => 'Moyenne',
			 'description' => "Le sort fonctionne jusqu'à 30 m (20 cases), plus 3 m (2 cases) par niveau de lanceur de sorts."
		  ),
		  array(
			 'nameId' => 'long',
			 'name' => 'Longue',
			 'description' => "Le sort peut atteindre 120 m (60 cases), plus 12 m (8 cases) par niveau de lanceur de sorts."
		  ),
		  array(
			 'nameId' => 'unlimited',
			 'name' => 'Illimitée',
			 'description' => "Le sort peut prendre effet n'importe où dans le même plan que le personnage."
		  )
	   );

	   foreach ($ranges as $data) {
		  $range = new BattleRange();
		  $range->setNameId($data['nameId']);
		  $range->setName($data['name']);
		  $range->setDescription($data['description']);
		  $manager->persist($range);
	   }
	   $manager->flush();
    }

    public function getOrder() {
	   return 6;
    }

}
