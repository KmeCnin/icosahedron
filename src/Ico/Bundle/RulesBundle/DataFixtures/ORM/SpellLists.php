<?php

namespace Ico\Bundle\TrainingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ico\Bundle\RulesBundle\Entity\SpellList;

class SpellLists implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
	   
	   $lists = array(
		  array(
			 'nameId' => 'bard',
			 'name' => 'Barde',
			 'short' => 'Bard'
		  ),
		  array(
			 'nameId' => 'sorcerer-wizard',
			 'name' => 'Ensorceleur/Magicien',
			 'short' => 'Ens/Mag'
		  ),
		  array(
			 'nameId' => 'ranger',
			 'name' => 'Rôdeur',
			 'short' => 'Rôd'
		  ),
		  array(
			 'nameId' => 'cleric',
			 'name' => 'Prêtre',
			 'short' => 'Prê'
		  ),
		  array(
			 'nameId' => 'oracle',
			 'name' => 'Oracle',
			 'short' => 'Ora'
		  ),
		  array(
			 'nameId' => 'summoner',
			 'name' => 'Conjurateur',
			 'short' => 'Conj'
		  ),
		  array(
			 'nameId' => 'witch',
			 'name' => 'Sorcière',
			 'short' => 'Sor'
		  ),
		  array(
			 'nameId' => 'druid',
			 'name' => 'Druide',
			 'short' => 'Dru'
		  ),
		  array(
			 'nameId' => 'alchemist',
			 'name' => 'Alchimiste',
			 'short' => 'Alc'
		  ),
		  array(
			 'nameId' => 'paladin',
			 'name' => 'Paladin',
			 'short' => 'Pal'
		  ),
		  array(
			 'nameId' => 'antipaladin',
			 'name' => 'Antipaladin',
			 'short' => 'Antipal'
		  ),
		  array(
			 'nameId' => 'inquisitor',
			 'name' => 'Inquisiteur',
			 'short' => 'Inq'
		  ),
		  array(
			 'nameId' => 'magus',
			 'name' => 'Magus',
			 'short' => 'Mgs'
		  ),
	   );

	   foreach ($lists as $data) {
		  $list = new SpellList();
		  $list->setNameId($data['nameId']);
		  $list->setName($data['name']);
		  $list->setShort($data['short']);
		  $manager->persist($list);
	   }
	   $manager->flush();
    }

    public function getOrder() {
	   return 3;
    }

}
