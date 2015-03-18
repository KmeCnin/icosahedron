<?php

namespace Ico\Bundle\ParserBundle\Services;

use Ico\Bundle\ParserBundle\Services\TruncatorManager;

class RulesManager {
    
    protected $truncator_manager;
    
    public function __construct() {
        $this->truncator_manager = new TruncatorManager();
    }
    
    public function getAllRules() {
	   
    }

    public function truncateTable($target) {
        
        $truncator = $this->truncator_manager->getTruncator($target);
        $truncator->truncate($target);
        
    }

}
