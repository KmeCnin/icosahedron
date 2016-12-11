<?php

namespace Ico\Bundle\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DoctrineFixturesExtendedCommand extends ContainerAwareCommand {

    protected $output;

    protected function configure() {
	   $this
			 ->setName('doctrine:fixtures:refresh')
			 ->setDescription('Load fixtures related to references tables after truncated')
			 ->setHelp(<<<EOT
The <info>doctrine:fixtures:refresh</info> load fixtures related to references tables after truncated
<info>php app/console doctrine:fixtures:refresh</info>
EOT
	   );
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
	   $this->output = $output;
	   ini_set('memory_limit', '512M');
	   $this->output->writeln(sprintf("<info>Deleting old data...</info>"));
	   foreach ($this->getTablesToTruncate() as $className) {
		  $this->truncateTable($className);
		  $this->output->writeln(sprintf("<info>\t<comment>%s</comment> deleted.</info>", $className));
	   }
	   $this->output->writeln(sprintf("<info>Old data deleted.</info>"));
	   $this->output->writeln(sprintf("<info>Loading fixtures...</info>"));
	   $this->loadFixtures();
	   $this->output->writeln(sprintf("<info>Fixtures loaded.</info>"));
    }

    public function truncateTable($className) {
	   $em = $this->getDoctrine()->getManager();
	   // Table de base
	   if (strpos($className, 'Ico') === 0) {
		  $cmd = $em->getClassMetadata($className);
		  $connection = $em->getConnection();
		  $dbPlatform = $connection->getDatabasePlatform();
		  $connection->beginTransaction();
		  try {
			 $connection->query('SET FOREIGN_KEY_CHECKS=0');
			 $q = $dbPlatform->getTruncateTableSql($cmd->getTableName(), true);
			 $connection->executeUpdate($q);
			 $connection->query('SET FOREIGN_KEY_CHECKS=1');
			 $connection->commit();
		  } catch (\Exception $e) {
			 $connection->rollback();
		  }
		  // Table de passage
	   } else {
		  $query = 'TRUNCATE TABLE `' . $className . '`';
		  $stmt = $this->getDoctrine()->getManager()->getConnection()->prepare($query);
		  $stmt->execute();
	   }
    }

    protected function getFixturesEntities() {
	   return array(
		  'IcoRulesBundle:FeatType',
		  'IcoRulesBundle:SpellSchool',
		  'IcoRulesBundle:SpellComponent',
		  'IcoRulesBundle:SpellList',
		  'IcoRulesBundle:BattleUnit',
		  'IcoRulesBundle:BattleRange',
		  'IcoRulesBundle:SavingThrow',
		  'IcoRulesBundle:SavingThrowEffect',
		  'IcoRulesBundle:SpellTargetType',
		  'IcoRulesBundle:LinkSource',
		  'IcoRulesBundle:Ability',
		  'IcoRulesBundle:Skill',
		  'IcoRulesBundle:CharacterClass',
		  'IcoRulesBundle:SizeCategory',
		  'IcoRulesBundle:Alignment',
		  'IcoKingmakerBundle:MapModel',
		  'IcoKingmakerBundle:MapInterestModel',
		  'IcoMassFightBundle:Tactic',
	   );
    }

    public function getTablesToTruncate() {
	   // Tables à vider toujours (car elles sont rechargées par les fixtures)
	   $tablesToTruncate = array();
	   foreach ($this->getFixturesEntities() as $entity) {
		  $tablesToTruncate[] = $entity;
	   }
//	   $tablesToTruncate[] = 'IcoRulesBundle:Skill';
	   $tablesToTruncate[] = 'IcoRulesBundle:CharacterClassLevel';
	   $tablesToTruncate[] = 'characterclass_skill';
	   $tablesToTruncate[] = 'characterclass_characterclasslevel';
	   $tablesToTruncate[] = 'characterclasslevel_characterclasslevelspecial';
	   return $tablesToTruncate;
    }

    public function loadFixtures() {
	   $kernel = $this->getContainer()->get('kernel');
	   $application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
	   $application->setAutoExit(false);
	   // Les fixtures sont chargées à la suite des données existentes, pour éviter les doublons, il faut s'assurer d'appeler truncateTable() de toutes les tables concernées.
	   $options = array('command' => 'doctrine:fixtures:load', "--append" => true);
	   $application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
    }

    protected function getDoctrine() {
	   return $this->getContainer()->get('doctrine');
    }

}
