<?php

namespace Ico\Bundle\ParserBundle\Services;

use Ico\Bundle\ParserBundle\Services\TruncatorManager;

class FixturesManager {
    
    protected $truncator_manager;
    
    public function __construct(TruncatorManager $truncator_manager) {
        $this->truncator_manager = $truncator_manager;
    }

    public function truncateTable($target) {
        
        $truncator = $this->truncator_manager->getTruncator($target);
        $truncator->truncate($target);
        
    }

}
