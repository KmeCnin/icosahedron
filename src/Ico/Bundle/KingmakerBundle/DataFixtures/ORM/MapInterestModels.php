<?php

namespace Ico\Bundle\KingmakerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ico\Bundle\KingmakerBundle\Entity\MapInterestModel;

class MapInterestModels implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
	   
	   $models = array(
               'Pont',
               'Campement',
               'Cadavre',
               'Hute',
               'Repaire',
               'Monument',
               'Monstre',
               'Plante',
               'Ressource',
               'Ruine',
               'Édifice',
               'Piège',
               'Ville',
           );

	   foreach ($models as $name) {
		  $model = new MapInterestModel();
		  $model->setName($name);
		  $manager->persist($model);
	   }
	   $manager->flush();
    }

    public function getOrder() {
	   return 2;
    }

}
