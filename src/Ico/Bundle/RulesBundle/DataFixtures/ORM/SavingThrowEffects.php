<?php

namespace Kiwi\Bundle\TrainingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ico\Bundle\RulesBundle\Entity\SavingThrowEffect;

class SavingThrowEffects implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
	   $savingthroweffects = array(
		  array(
			 'name_id' => 'negates',
			 'name' => 'Annule',
			 'description' => "Le sort n'a aucun effet sur une créature qui réussit son jet de sauvegarde."
		  ),
		  array(
			 'name_id' => 'partial',
			 'name' => 'Partiel',
			 'description' => 'Normalement, le sort a un effet donné sur la cible. Si cette dernière réussit son jet de sauvegarde, elle subit un effet moindre.'
		  ),
		  array(
			 'name_id' => 'half',
			 'name' => '1/2 dégâts',
			 'description' => "Les dégâts du sort sont réduits de moitié (en arrondissant à l'entier inférieur) en cas de jet de sauvegarde réussi."
		  ),
		  array(
			 'name_id' => 'none',
			 'name' => 'Aucun',
			 'description' => "Le sort n'autorise aucun jet de sauvegarde."
		  ),
		  array(
			 'name_id' => 'disbelief',
			 'name' => 'Dévoile',
			 'description' => "En cas de jet de sauvegarde réussi, la cible prend conscience qu'elle a affaire à une illusion."
		  ),
		  array(
			 'name_id' => 'objet',
			 'name' => 'Objet',
			 'description' => "Le sort peut être jeté sur un objet, qui ne bénéficie d'un jet de sauvegarde uniquement s'il est magique ou s'il est en possession de quelqu'un qui résiste au sort (porté, tenu en main, agrippé etc.). Dans ce cas, l'objet utilise le bonus au jet de sauvegarde de son porteur, à moins que le sien ne soit supérieur. Ce terme ne veut pas dire que le sort s'applique uniquement à un objet. Certains sorts de ce type peuvent être lancés sur des créatures ou des objets. Le bonus au jet de sauvegarde d'un objet magique est égal à 2 plus la moitié de son niveau de lanceur de sorts."
		  ),
		  array(
			 'name_id' => 'inoffensif',
			 'name' => 'Inoffensif',
			 'description' => "Il s'agit généralement d'un sort bénéfique et non offensif mais la cible peut faire un jet de sauvegarde si elle le désire."
		  )
	   );

	   foreach ($savingthroweffects as $data) {
		  $savingthroweffect = new SavingThrowEffect();
		  $savingthroweffect->setNameId($data['name_id']);
		  $savingthroweffect->setName($data['name']);
		  $savingthroweffect->setDescription($data['description']);
		  $manager->persist($savingthroweffect);
	   }
	   $manager->flush();
    }

    public function getOrder() {
	   return 8;
    }

}
