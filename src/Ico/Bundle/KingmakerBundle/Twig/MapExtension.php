<?php

namespace Ico\Bundle\KingmakerBundle\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

class MapExtension extends Twig_Extension {

    private $hexSide = 89;

    public function getFunctions() {
        return array(
            'fillTheMap' => new Twig_SimpleFunction('fillTheMap', array($this, 'fillTheMap'))
        );
    }

    public function fillTheMap(\Ico\Bundle\KingmakerBundle\Entity\MapModel $model) {
        $svg = '<svg>';
        $y = $model->getStart()->getY();
        for ($i = 1; $i <= $model->getNbLines(); $i++) {
            if ($i % 2 == 0) {
                $x = $model->getStart()->getX() + $this->getHalfH();
            } else {
                $x = $model->getStart()->getX();
            }
            for ($j = 1; $j <= $model->getNbCols(); $j++) {
                $svg .= $this->drawHex($x, $y, $i.'_'.$j);
                $x = $x + (2 * $this->getHalfH());
            }
            $y = $y + $this->getFullV() + $this->getHalfV();
        }
        $svg .= '</svg>';
        
        return $svg;
    }

    private function drawHex($x, $y, $id) {
        $dots = array();
        $dots[] = array($x, $y); // 1
        $dots[] = array($x + $this->getHalfH(), $y - $this->getHalfV()); // 2
        $dots[] = array($x + (2 * $this->getHalfH()), $y); // 3
        $dots[] = array($x + (2 * $this->getHalfH()), $y + $this->getFullV()); // 4
        $dots[] = array($x + $this->getHalfH(), $y + $this->getFullV() + $this->getHalfV()); // 5
        $dots[] = array($x, $y + $this->getFullV()); // 6

        $hex = '<path onclick="$(\'#modal_hex_'.$id.'\').modal(\'show\');" id="hex_'.$id.'" class="hex" d="M ';
        foreach ($dots as $i => $dot) {
            $x = $dot[0];
            $y = $dot[1];
            $hex .= $x . ',' . $y;
            if ($i != count($dots) - 1) {
                $hex .= ' L';
            }
        }
        $hex .= '" />';
        
        return $hex;
    }

    private function getHalfH() {
//        return 77;
        return sqrt(($this->hexSide*$this->hexSide) - (($this->hexSide * 0.5) * ($this->hexSide * 0.5)));
    }

    private function getHalfV() {
//        return 42;
        return $this->hexSide * 0.5;
    }

    private function getFullV() {
        return $this->hexSide;
    }

    public function getName() {
        return 'map_extension';
    }

}
