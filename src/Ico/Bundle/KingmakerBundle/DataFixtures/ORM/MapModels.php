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
                   'start' => array('x' => -233, 'y' => -130),
                   'nbLines' => 13,
                   'nbCols' => 10,
                   'hexSide' => 89,
               ),
               array(
                   'name' => 'Les Hauts de Nomens',
                   'description' => '',
                   'start' => array('x' => -232, 'y' => -122),
                   'nbLines' => 13,
                   'nbCols' => 10,
                   'hexSide' => 89,
               ),
               array(
                   'name' => 'Le Marais de Crochelangue',
                   'description' => '',
                   'start' => array('x' => -228, 'y' => -129),
                   'nbLines' => 13,
                   'nbCols' => 10,
                   'hexSide' => 89,
               ),
               array(
                   'name' => 'Les Hautes Terres de Glenebon',
                   'description' => '',
                   'start' => array('x' => -235, 'y' => -133),
                   'nbLines' => 13,
                   'nbCols' => 10,
                   'hexSide' => 89,
               ),
           );

	   foreach ($models as $data) {
		  $model = new MapModel();
		  $model->setName($data['name']);
		  $model->setDescription($data['description']);
		  $model->setStart(new Dot($data['start']['x'], $data['start']['y']));
		  $model->setNbLines($data['nbLines']);
		  $model->setNbCols($data['nbCols']);
		  $model->setHexSide($data['hexSide']);
		  $manager->persist($model);
	   }
	   $manager->flush();
    }

    public function getOrder() {
	   return 1;
    }

}
