<?php

namespace Kiwi\Bundle\TrainingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ico\Bundle\RulesBundle\Entity\BattleUnit;

class BattleUnits implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
	   
	   $units = array(
		  array(
			 'nameId' => 'freeAction',
			 'name' => 'action libre',
			 'plurial' => 'actions libres',
			 'description' => "Les actions libres prennent un temps négligeable et ne demandent presque aucun effort. Le personnage peut en accomplir une ou plusieurs tout en exécutant l'action qu'il a choisie. On peut effectuer plusieurs actions libres au cours d'un round, dans les limites du raisonnable et avec l'accord du MJ.",
			 'detail' => "Les actions libres prennent un temps négligeable et ne demandent presque aucun effort. Le personnage peut en accomplir une ou plusieurs tout en exécutant l'action qu'il a choisie. On peut effectuer plusieurs actions libres au cours d'un round, dans les limites du raisonnable et avec l'accord du MJ."
		  ),
		  array(
			 'nameId' => 'immediateAction',
			 'name' => 'action instantanée',
			 'plurial' => 'actions instantanées',
			 'description' => "Une action immédiate ressemble fort à une action rapide, si ce n’est qu'elle peut être accomplie à n'importe quel moment, même si ce n'est pas le tour du personnage.",
			 'detail' => "Une action immédiate ressemble fort à une action rapide, si ce n’est qu'elle peut être accomplie à n'importe quel moment, même si ce n'est pas le tour du personnage."
		  ),
		  array(
			 'nameId' => 'swiftAction',
			 'name' => 'action rapide',
			 'plurial' => 'actions rapides',
			 'description' => "Une action rapide demande peu de temps mais représente une dépense d'énergie ou un effort plus important qu'une action libre. On ne peut accomplir qu'une action rapide par tour.",
			 'detail' => "Une action rapide demande peu de temps mais représente une dépense d'énergie ou un effort plus important qu'une action libre. On ne peut accomplir qu'une action rapide par tour."
		  ),
		  array(
			 'nameId' => 'movementAction',
			 'name' => 'action de mouveent',
			 'plurial' => 'actions de mouvements',
			 'description' => "L'action de mouvement permet au personnage de se déplacer sur une distance égale ou inférieure à sa vitesse de base ou d'accomplir une action demandant le même temps.",
			 'detail' => "L'action de mouvement permet au personnage de se déplacer sur une distance égale ou inférieure à sa vitesse de base ou d'accomplir une action demandant le même temps.<br />
On peut faire une action de mouvement au lieu d'une action simple. Si un personnage ne se déplace pas au cours du round (souvent parce qu'il a troqué son déplacement contre une ou plusieurs actions équivalentes), il peut tout de même accomplir un pas de placement de 1,50 m, pendant, avant ou après son action."
		  ),
		  array(
			 'nameId' => 'simpleAction',
			 'name' => 'action simple',
			 'plurial' => 'actions simples',
			 'description' => "Une action simple permet d'accomplir quelque chose, comme attaquer ou lancer un sort.",
			 'detail' => "Une action simple permet d'accomplir quelque chose, comme attaquer ou lancer un sort."
		  ),
		  array(
			 'nameId' => 'fullRoundAction',
			 'name' => 'action complexe',
			 'plurial' => 'actions complexes',
			 'description' => "Une action complexe demande un round entier. Le déplacement du personnage se limite à un pas de placement (avant, pendant ou après son action). Il peut aussi accomplir des actions libres et des actions rapides.",
			 'detail' => "Une action complexe demande un round entier. Le déplacement du personnage se limite à un pas de placement (avant, pendant ou après son action). Il peut aussi accomplir des actions libres et des actions rapides.<br />
Certaines actions complexes ne laissent pas de temps pour un pas de placement.<br />
Le personnage peut effectuer certaines actions complexes en tant qu'actions simples, mais uniquement s'il réduit son activité à une seule action simple par round. La description des actions complexes indique si cela est possible."
		  ),
		  array(
			 'nameId' => 'round',
			 'name' => 'round',
			 'plurial' => 'rounds',
			 'description' => "",
			 'detail' => ""
		  ),
		  array(
			 'nameId' => 'minute',
			 'name' => 'minute',
			 'plurial' => 'minutes',
			 'description' => "",
			 'detail' => ""
		  ),
		  array(
			 'nameId' => 'hour',
			 'name' => 'heure',
			 'plurial' => 'heures',
			 'description' => "",
			 'detail' => ""
		  ),
	   );

	   foreach ($units as $data) {
		  $unit = new BattleUnit();
		  $unit->setNameId($data['nameId']);
		  $unit->setName($data['name']);
		  $unit->setPlurial($data['plurial']);
		  $unit->setDescription($data['description']);
		  $unit->setDetail($data['detail']);
		  $manager->persist($unit);
	   }
	   $manager->flush();
    }

    public function getOrder() {
	   return 5;
    }

}
