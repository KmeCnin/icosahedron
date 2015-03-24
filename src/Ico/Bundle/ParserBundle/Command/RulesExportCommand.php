<?php

namespace Ico\Bundle\ParserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
//use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

use Ico\Bundle\ParserBundle\Services\DatabaseFormater;
use Ico\Bundle\ParserBundle\Services\DatabaseExporter;

class RulesExportCommand extends ContainerAwareCommand {

    protected $format;

    protected function configure() {
	   $this
			 ->setName('parser:rules:export')
			 ->setDescription('Exporter les règles à partir de la BDD')
			 ->addArgument('format', InputArgument::OPTIONAL, 'Dans quel format voulez-vous exporter ? [xml]');
    }
    
    
    protected function init(InputInterface $input) {
	   $format = $input->getArgument('format');
	   if ($format) {
		  if (!DatabaseFormater::isFormatAccepted($format)) {
			 throw new InvalidArgumentException($format.' : Format inconnu. Formats acceptés : '.inplode(', ', DatabaseFormater::getFormatsAccepted()));
		  }
		  $this->format = $input->getArgument('format');
	   } else {
		  $this->format = DatabaseFormater::XML;
	   }
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        
	   $this->init($input);
	   
	   /* @var $databaseExporter DatabaseExporter */
        $databaseExporter = $this->getContainer()->get('ico.parser.services.database_exporter');
        $output->writeln('Exporting Database to '.$this->format.' into '.$databaseExporter->path);
	   $databaseExporter->export($this->format);
        
    }

}
