<?php

namespace Kiwi\Bundle\TrainingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ico\Bundle\RulesBundle\Entity\SpellComponent;

class SpellComponents implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
	   
	   $components = array(
		  array(
			 'nameId' => 'V',
			 'name' => 'Verbale',
			 'description' => "Une composante verbale représente un texte à réciter. Le personnage doit donc s'exprimer à haute et intelligible voix. Un sort de silence ou un bâillon ne le permet pas et empêche donc l'incantation du sort. Un personnage sourd a 20 % de chances de rater ses sorts à composante verbale."
		  ),
		  array(
			 'nameId' => 'G',
			 'name' => 'Gestuelle',
			 'description' => "Une composante gestuelle (ou somatique) prend la forme d'un geste précis de la main ou de toute autre partie du corps. Pour ce faire, il faut avoir au moins une main libre."
		  ),
		  array(
			 'nameId' => 'M',
			 'name' => 'Matérielle',
			 'description' => "Une composante matérielle est un objet ou une substance détruit par l'énergie magique en cours d'incantation. Si son prix n'est pas indiqué, on considère qu'il est négligeable. Il n'est pas nécessaire de comptabiliser les composantes matérielles peu onéreuses. On part du principe que le personnage dispose de tout ce dont il a besoin tant qu'il a accès à sa sacoche à composantes."
		  ),
		  array(
			 'nameId' => 'F',
			 'name' => 'Focaliseur',
			 'description' => "Le focaliseur est une sorte d'accessoire. Contrairement à la composante matérielle classique, le focaliseur n'est pas détruit lors de l'incantation et peut donc être réutilisé. Là aussi, sauf indication contraire, le prix est négligeable. On part du principe que le personnage possède automatiquement tous les focaliseurs à coût modique dont il a besoin dans sa sacoche à composantes."
		  ),
		  array(
			 'nameId' => 'FD',
			 'name' => 'Focaliseur divin',
			 'description' => "Un focaliseur divin est un objet lourd de signification religieuse. Pour les prêtres et les paladins, il s'agit d'un symbole sacré qui représente leur foi. Pour un druide ou un rôdeur, il s'agira d'une branche de houx ou d'une autre plante sacrée."
		  ),
	   );

	   foreach ($components as $data) {
		  $component = new SpellComponent();
		  $component->setNameId($data['nameId']);
		  $component->setName($data['name']);
		  $component->setDescription($data['description']);
		  $manager->persist($component);
	   }
	   $manager->flush();
    }

    public function getOrder() {
	   return 2;
    }

}
