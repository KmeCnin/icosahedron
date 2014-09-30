<?php

namespace Kiwi\Bundle\TrainingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ico\Bundle\RulesBundle\Entity\SpellList;

class SpellLists implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
	   
	   $lists = array(
		  array(
			 'nameId' => 'bard',
			 'name' => 'Barde'
		  ),
		  array(
			 'nameId' => 'sorcerer-wizard',
			 'name' => 'Ensorceleur/Magicien'
		  ),
		  array(
			 'nameId' => 'ranger',
			 'name' => 'Rôdeur'
		  ),
		  array(
			 'nameId' => 'cleric',
			 'name' => 'Prêtre'
		  ),
		  array(
			 'nameId' => 'oracle',
			 'name' => 'Oracle'
		  ),
		  array(
			 'nameId' => 'summoner',
			 'name' => 'Conjurateur'
		  ),
		  array(
			 'nameId' => 'witch',
			 'name' => 'Sorcière'
		  ),
		  array(
			 'nameId' => 'druid',
			 'name' => 'Druide'
		  ),
		  array(
			 'nameId' => 'alchemist',
			 'name' => 'Alchimiste'
		  ),
		  array(
			 'nameId' => 'paladin',
			 'name' => 'Paladin'
		  ),
		  array(
			 'nameId' => 'antipaladin',
			 'name' => 'Antipaladin'
		  ),
		  array(
			 'nameId' => 'inquisitor',
			 'name' => 'Inquisiteur'
		  ),
		  array(
			 'nameId' => 'magus',
			 'name' => 'Magus'
		  ),
	   );

	   foreach ($lists as $data) {
		  $list = new SpellList();
		  $list->setNameId($data['nameId']);
		  $list->setName($data['name']);
		  $manager->persist($list);
	   }
	   $manager->flush();
    }

    public function getOrder() {
	   return 3;
    }

}
