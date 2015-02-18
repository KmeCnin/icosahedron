<?php

namespace Ico\Bundle\KingmakerBundle\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

class MapExtension extends Twig_Extension {
    
    public function getFunctions() {
        return array(
            'fillTheMap' => new Twig_SimpleFunction('fillTheMap', array($this, 'fillTheMap'))
        );
    }

    public function fillTheMap(\Ico\Bundle\KingmakerBundle\Entity\MapModel $model) {
        $svg = '<svg>';
        for ($i = 1; $i <= $model->getNbLines(); $i++) {
            if ($i % 2 == 0) {
                $x = $model->getStart()->getX() + $params['half_to_right'];
            } else {
                $x = $model->getStart()->getX();
            }
            for ($j = 1; $j <= $model->getNbCols(); $j++) {
                $this->drawHex($x, $y);
                $x = $x + (2 * $params['half_to_right']);
            }
            $y = $y + $params['big_height'] + $params['half_to_bottom'];
        }
        $svg += '</svg>';

        return $svg;
    }

    public function getName() {
        return 'map_extension';
    }

}
