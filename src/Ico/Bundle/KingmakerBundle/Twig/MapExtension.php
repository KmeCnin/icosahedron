<?php

namespace Ico\Bundle\KingmakerBundle\Twig;

use Doctrine\ORM\EntityManager;
use Ico\Bundle\KingmakerBundle\Entity\Dot;
use Ico\Bundle\KingmakerBundle\Entity\Hex;
use Ico\Bundle\KingmakerBundle\Entity\Map;
use Twig_Extension;
use Twig_SimpleFunction;

class MapExtension extends Twig_Extension {

    protected $hexSide;
    protected $em;
    
    protected $frontier;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function getFunctions() {
        return array(
            'fillTheMap' => new Twig_SimpleFunction('fillTheMap', array($this, 'fillTheMap')),
            'addFrontier' => new Twig_SimpleFunction('addFrontier', array($this, 'addFrontier'))
        );
    }
    
    public function addFrontier(Map $map) {
        
        $this->fillTheMap($map);

        return $this->frontier;
    }

    public function fillTheMap(Map $map) {
        
        $model = $map->getMapModel();
        $this->hexSide = $model->getHexSide();
        $svg = '';
        $y = $model->getStart()->getY();
        for ($i = 1; $i <= $model->getNbLines(); $i++) {
            if ($i % 2 == 0) {
                $x = $model->getStart()->getX() + $this->getHalfH();
            } else {
                $x = $model->getStart()->getX();
            }
            for ($j = 1; $j <= $model->getNbCols(); $j++) {

                $hexEntity = $this->em
                        ->getRepository('IcoKingmakerBundle:Hex')
                        ->findCoordinates($i, $j, $map);
                
                if ($hexEntity->getStart() == null) {
                    $hexEntity->setStart(new Dot($x, $y));
                    $this->em->persist($hexEntity);
                }

                $svg .= $this->drawHex($x, $y, $hexEntity);
                $x = $x + (2 * $this->getHalfH());
            }
            $y = $y + $this->getFullV() + $this->getHalfV();
        }
        $this->em->flush();

        return $svg;
    }
    
    protected function drawBorder(Hex $hexEntity, $dots) {
        $frontier = '';
        $adjacents = $this->em
                ->getRepository('IcoKingmakerBundle:Hex')
                ->findAdjacents($hexEntity);
        foreach ($adjacents as $clock => $adjacent) {
            if (!$adjacent->getAnnexed()) {
                $frontier .= '<path class="frontier" d="M '.$dots[$clock][0].','.$dots[$clock][1].' L '.$dots[$clock+1][0].','.$dots[$clock+1][1].'" />';
            }
        }
        $this->frontier .= $frontier;
    }

    protected function drawHex($x, $y, Hex $hexEntity) {
        
        $dots = array();
        $dots[] = array($x, $y); // 1
        $dots[] = array($x + $this->getHalfH(), $y - $this->getHalfV()); // 2
        $dots[] = array($x + (2 * $this->getHalfH()), $y); // 3
        $dots[] = array($x + (2 * $this->getHalfH()), $y + $this->getFullV()); // 4
        $dots[] = array($x + $this->getHalfH(), $y + $this->getFullV() + $this->getHalfV()); // 5
        $dots[] = array($x, $y + $this->getFullV()); // 6
        $dots[] = array($x, $y); // 7
        
        $hex = '<path x="'.$hexEntity->getX().'" y="'.$hexEntity->getY().'" class="hex';
        if ($hexEntity->getExplored()) {
            $hex .= ' explored';
            if ($hexEntity->getAnnexed()) {
                $hex .= ' annexed';
            }
        }
        $hex .= '" id="hex_' . $hexEntity->getId() . '" d="M ';
        
        foreach ($dots as $i => $dot) {
            $x = $dot[0];
            $y = $dot[1];
            $hex .= $x . ',' . $y;
            if ($i != count($dots) - 1) {
                $hex .= ' L ';
            }
        }
        $hex .= '" />';
        
        // Drawing Frontier
        if ($hexEntity->getAnnexed()) {
            $this->drawBorder($hexEntity, $dots);
        }

        return $hex;
    }

    protected function getHalfH() {
        return sqrt(($this->hexSide * $this->hexSide) - (($this->hexSide * 0.5) * ($this->hexSide * 0.5)));
    }

    protected function getHalfV() {
        return $this->hexSide * 0.5;
    }

    protected function getFullV() {
        return $this->hexSide;
    }

    public function getName() {
        return 'map_extension';
    }

}
