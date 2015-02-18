<?php

namespace Ico\Bundle\KingmakerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ico\Bundle\KingmakerBundle\Entity\MapModel;
use Ico\Bundle\KingmakerBundle\Entity\Dot;

class MapModels implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
	   
	   $models = array(
               array(
                   'name' => 'La Ceinture Verte',
                   'description' => '',
                   'start' => array('x' => -246, 'y' => -137),
                   'nbLines' => 13,
                   'nbCols' => 10,
               ),
           );

	   foreach ($models as $data) {
		  $model = new MapModel();
		  $model->setName($data['name']);
		  $model->setDescription($data['description']);
		  $model->setStart(new Dot($data['start']['x'], $data['start']['y']));
		  $model->setNbLines($data['nbLines']);
		  $model->setNbCols($data['nbCols']);
		  $manager->persist($model);
	   }
	   $manager->flush();
    }

    public function getOrder() {
	   return 1;
    }

}
