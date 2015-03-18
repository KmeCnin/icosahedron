<?php

namespace Ico\Bundle\ParserBundle\Interfaces;

interface DatabaseFormater {
    
    /**
     * 
     * 
     * @param array $entries Tableau de données correspondant à une table d'entités doctrine
     */
    public function format($entries);	   
    
}
