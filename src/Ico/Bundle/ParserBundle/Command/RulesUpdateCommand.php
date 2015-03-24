<?php

namespace Ico\Bundle\ParserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
//use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;
//use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

use Ico\Bundle\RulesBundle\Entity\Feat;
use Ico\Bundle\RulesBundle\Entity\FeatPrerequisite;
use Ico\Bundle\RulesBundle\Entity\Spell;
use Ico\Bundle\RulesBundle\Entity\SpellListLevel;
use Ico\Bundle\RulesBundle\Entity\BattleTime;
use Ico\Bundle\RulesBundle\Entity\Link;

use Ico\Bundle\ParserBundle\Services\DatabaseExporter;

class RulesUpdateCommand extends ContainerAwareCommand {

    protected $updateOnlyFixtures = false;
    protected $updateFeats = true;
    protected $updateSpells = true;
    protected $output;

    protected function configure() {
	   $this
			 ->setName('parser:update:rules')
			 ->setDescription('Update all data for rules from xml files')
			 ->addOption('fixtures', null, InputOption::VALUE_NONE, 'Update only fixtures')
			 ->addOption('feats', null, InputOption::VALUE_NONE, 'Update all feats')
			 ->addOption('spells', null, InputOption::VALUE_NONE, 'Update all spells')
			 ->setHelp(<<<EOT
The <info>parser:update:rules</info> command update the database of rules
from xml data.
<info>php app/console parser:update:rules</info>
You can also optionally specify the data to update if you don't want all:
<info>php app/console parser:update:rules --fixtures</info>
<info>php app/console parser:update:rules --feats</info>
<info>php app/console parser:update:rules --spells</info>
EOT
	   );
    }

    protected function defineOptions(InputInterface $input) {
	   if ($input->getOption('fixtures')) {
		  $this->updateOnlyFixtures = true;
		  $this->updateFeats = false;
		  $this->updateSpells = false;
	   }
	   if ($input->getOption('feats') || $input->getOption('spells')) {
		  $this->updateFeats = $input->getOption('feats');
		  $this->updateSpells = $input->getOption('spells');
	   }
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        
        $this->defineOptions($input);
        $this->output = $output;
	   
	   /* @var $databaseExporter DatabaseExporter */
        $databaseExporter = $this->get('ico.parser.services.database_exporter');
	   $databaseExporter->export(DatabaseFormater::XML);
        
        
    }

}
