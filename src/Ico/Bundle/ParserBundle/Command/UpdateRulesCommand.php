<?php

namespace Ico\Bundle\ParserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

use Ico\Bundle\RulesBundle\Entity\Feat;
use Ico\Bundle\RulesBundle\Entity\FeatPrerequisite;
use Ico\Bundle\RulesBundle\Entity\Spell;
use Ico\Bundle\RulesBundle\Entity\SpellListLevel;
use Ico\Bundle\RulesBundle\Entity\BattleTime;

class UpdateRulesCommand extends ContainerAwareCommand
{
    protected $updateOnlyFixtures = false;
    protected $updateFeats = true;
    protected $updateSpells = true;
    protected $output;
    
    protected $metadatas;
    protected $currentFeat;
    protected $maxEntitiesStacked = 100; // Number of entities to persist before to flush them
    
    protected function configure()
    {
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
		  if (!$input->getOption('feats')) {
			 $this->updateFeats = false;
		  } else {
			 $this->updateFeats = true;
		  }
		  if (!$input->getOption('spells')) {
			 $this->updateSpells = false;
		  } else {
			 $this->updateSpells = true;
		  }
	   }
	   
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
	   $this->defineOptions($input);
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
	   
	   // On récupère les nouvelles infos
	   if (!$this->updateOnlyFixtures) {
		  $this->output->writeln(sprintf("<info>Updating new data:</info>"));
		  if ($this->updateFeats) {
			 $this->output->writeln(sprintf("<info>\tUpdating Feats...</info>"));	
			 $logs = $this->updateFeats();
			 $this->output->writeln(sprintf("<info>\t%d feats updated.</info>", count($logs)));	
		  }
		  if ($this->updateSpells) {
			 $this->output->writeln(sprintf("<info>\tLoading Spells...</info>"));
			 $logs = $this->updateSpells();
			 $this->output->writeln(sprintf("<info>\t%d spells updated.</info>", count($logs)));	
		  }
		  $this->output->writeln('Data updated.');
	   }
    }
    
    private function encode($string) {
	   return mb_convert_encoding($string, 'CP850', 'UTF-8');
    }
    
    private function updateFeats() {
	   $url = 'http://db.pathfinder-fr.org/raw/feats.xml';
	   $crawler = new Crawler;
	   $crawler->addHTMLContent(file_get_contents($url), 'UTF-8');
	   $em = $this->getDoctrine()->getManager();
	   $logs = $crawler->filter('feat')->each(function (Crawler $node) {
		  set_time_limit(15) ;
		  $em = $this->getDoctrine()->getManager();
		  $feat = new Feat(); 
		  $this->currentFeat = $node->attr('id');
		  $feat->setNameId($node->attr('id'));
		  $feat->setName($node->attr('name'));
		  $feat->setWiki($node->filter('reference')->eq(0)->attr('href'));
		  $feat->setDescription($node->filter('description')->text());
		  $feat_types = $node->filter('type')->each(function (Crawler $type) {
			 return $this->getEntityFromNameId('FeatType', $type->text());
		  });
		  $metadatas = $node->filter('prerequisite')->each(function (Crawler $prerequisite) {
			 $metadata = array();
			 $metadata['html'] = $prerequisite->text();
			 $metadata['feat'] = $this->currentFeat;
			 $metadata['type'] = $prerequisite->attr('type');
			 if ($prerequisite->attr('type') == 'other') {
				if ($prerequisite->attr('otherType') > 0 && $prerequisite->attr('otherType') == 'ExoticWeaponProficiency') {
				    $metadata['otherType'] = $prerequisite->attr('otherType');
				    $metadata['value'] = $prerequisite->attr('value');
				}
			 } elseif ($prerequisite->attr('type') == 'bba') {
				$metadata['number'] = $prerequisite->attr('number');
			 } elseif ($prerequisite->attr('type') == 'attribute') {
				$metadata['value'] = $prerequisite->attr('value');
				$metadata['number'] = $prerequisite->attr('number');
			 } elseif ($prerequisite->attr('type') == 'race') {
				$metadata['value'] = $prerequisite->attr('value');
			 } elseif ($prerequisite->attr('type') == 'classLevel') {
				$metadata['value'] = $prerequisite->attr('value');
				$metadata['number'] = $prerequisite->attr('number');
			 } elseif ($prerequisite->attr('type') == 'ClassPower') {
				$metadata['value'] = $prerequisite->attr('value');
			 } elseif ($prerequisite->attr('type') == 'skillRank') {
				$metadata['value'] = $prerequisite->attr('value');
				$metadata['number'] = $prerequisite->attr('number');
			 } elseif ($prerequisite->attr('type') == 'spellCast') {
				$metadata['value'] = $prerequisite->attr('value');
			 } elseif ($prerequisite->attr('type') == 'feat') {
				$metadata['value'] = $prerequisite->attr('value');
			 }	
			 return $metadata;
		  });
		  $this->metadatas[] = $metadatas;
		  foreach ($feat_types as $feat_type) {
			 $feat->addFeatType($feat_type);
		  }
		  if ($node->filter('benefit')->count() > 0) {
			 $feat->setBenefit($node->filter('benefit')->text());
		  } else {
			 $feat->setBenefit($feat->getDescription());
		  }
		  $em->persist($feat);
		  if (count($em->getUnitOfWork()->getScheduledEntityInsertions()) > $this->maxEntitiesStacked) {
			 $em->flush();
		  }
		  $this->output->writeln(sprintf(chr(8)."<info>\t\t%s</info>", $this->encode($feat->getName())));
		  
		  return $feat->getNameId();
	   });
	   $em->flush();
	   
	   $this->output->writeln(sprintf("<info>\tCreating related links...</info>"));
	   // Mise à jour des liens sur les dons
	   $this->updateFeatPrerequisites();
	   $this->output->writeln(sprintf("<info>\tLinks created.</info>"));
	   
	   return $logs;
    }
    
    private function updateSpells() {
	   $url = 'http://db.pathfinder-fr.org/raw/spells.xml';
	   $crawler = new Crawler;
	   $crawler->addHTMLContent(file_get_contents($url), 'UTF-8');
	   $em = $this->getDoctrine()->getManager();
	   $logs = $crawler->filter('spell')->each(function (Crawler $node) {
		  set_time_limit(15) ;
		  $em = $this->getDoctrine()->getManager();
		  $spell = new Spell(); 
		  $this->current_spell = $node->attr('id');
		  $spell->setNameId($node->attr('id'));
		  $spell->setName($node->filter('name')->text());
		  $spell->setWiki($node->filter('reference')->eq(0)->attr('href'));
		  if ($node->filter('summary')->count() > 0) {
			 $spell->setDescription($node->filter('summary')->text());
			 $spell->setDetail($node->filter('summary')->text());
		  } else {
			 $spell->setDescription('');
			 $spell->setDetail('');
		  }
		  if ($node->filter('target')->count() > 0) {
			 $spell->setTarget($node->filter('target')->text());
		  }
		  if ($node->filter('components')->count() > 0) {
			 $spell->setMaterialComponent($node->filter('components')->text());
		  }
		  if ($node->filter('castingTime')->count() > 0) {
			 if ($node->filter('castingTime')->attr('unit') && $node->filter('castingTime')->attr('unit') != 'special') {
				$castingTime = new BattleTime();
				$castingTime->setUnit($this->getEntityFromNameId('BattleUnit', $node->filter('castingTime')->attr('unit')));
				$castingTime->setValue($node->filter('castingTime')->attr('value'));
				$spell->setCastingTime($castingTime);
			 } elseif ($node->filter('castingTime')->attr('unit')) {
				$spell->setCastingTimeSpecial($node->filter('castingTime')->text());
			 } else {
				$castingTime = new BattleTime();
				$castingTime->setUnit($this->getEntityFromNameId('BattleUnit', 'simpleAction'));
				$castingTime->setValue($node->filter('castingTime')->attr('value'));
				$spell->setCastingTime($castingTime);
			 }
		  }
		  if ($node->filter('range')->count() > 0) {
			 if ($node->filter('range')->attr('unit') == 'squares') { // nombre de cases
				$spell->setCastingTimeSpecial($node->filter('castingTime')->text().' m ('.($node->filter('castingTime')->text()/1.5).' c)');
			 } else {
				$spell->setRange($this->getEntityFromNameId('BattleRange', $node->filter('range')->attr('unit')));
			 }
		  }
		  if ($node->filter('components')->count() > 0) {
			 $components = $node->filter('components')->attr('kinds');
			 foreach (explode(' ', $components) as $component) {
				if ($component == 'M/DF') {
				    $spell->addSpellComponent($this->getEntityFromNameId('SpellComponent', 'M'));
				    $spell->addSpellComponent($this->getEntityFromNameId('SpellComponent', 'DF'));
				} else {
				    $spell->addSpellComponent($this->getEntityFromNameId('SpellComponent', $component));
				}
			 }
		  }
		  $spell->setSpellSchool($this->getEntityFromNameId('SpellSchool', $node->attr('school')));
		  $spelllistlevels = $node->filter('level')->each(function (Crawler $data) {
			 $spelllistlevel = new SpellListLevel();
			 $spelllistlevel->setSpellList($this->getEntityFromNameId('SpellList', $data->attr('list')));
			 $spelllistlevel->setLevel($data->attr('level'));
			 return $spelllistlevel;
		  });
		  foreach ($spelllistlevels as $spelllistlevel) {
			 $spell->addSpellListsLevel($spelllistlevel);
		  }
		  $em->persist($spell);
		  if (count($em->getUnitOfWork()->getScheduledEntityInsertions()) > $this->maxEntitiesStacked) {
			 $em->flush();
		  }
		  $this->output->writeln(sprintf("<info>\t\t%s</info>", $this->encode($spell->getName())));
	   });
	   $em->flush();
	   
	   return $logs;
    }
    
    public function truncateTable($className) {
	   
	   $em = $this->getDoctrine()->getManager();
	   // Table de base
	   if (strpos($className, 'IcoRulesBundle:') === 0) {
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
		  $query = 'TRUNCATE TABLE `'.$className.'`';
		  $stmt = $this->getDoctrine()->getManager()->getConnection()->prepare($query);
		  $stmt->execute();
	   }
    }
    
    public function getTablesToTruncate() {
	   
	   // Tables à vider toujours (car elles sont rechargées par les fixtures)
	   $tablesToTruncate = array(
		  'IcoRulesBundle:FeatType', 
		  'IcoRulesBundle:SpellSchool', 
		  'IcoRulesBundle:SpellComponent', 
		  'IcoRulesBundle:SpellList', 
		  'IcoRulesBundle:BattleUnit', 
		  'IcoRulesBundle:BattleRange'
	   );
	   // Tables à vider seulement si on synchronise les dons
	   if ($this->updateFeats) {
		  $tablesToTruncate[] = 'IcoRulesBundle:Feat';
		  $tablesToTruncate[] = 'feat_feattype';
		  $tablesToTruncate[] = 'IcoRulesBundle:FeatPrerequisite';
	   }
	   // Tables à vider seulement si on synchronise les sorts
	   if ($this->updateSpells) {
		  $tablesToTruncate[] = 'IcoRulesBundle:Spell';
		  $tablesToTruncate[] = 'IcoRulesBundle:SpellListLevel';
		  $tablesToTruncate[] = 'IcoRulesBundle:BattleTime';
		  $tablesToTruncate[] = 'spell_spellcomponent';
		  $tablesToTruncate[] = 'spell_spelllistlevel';
	   }
	   
	   return $tablesToTruncate;
	   
    }
    
    public function loadFixtures() {
	   	
	   $kernel = $this->getContainer()->get('kernel');
	   $application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
	   $application->setAutoExit(false);
	   // Les fixtures sont chargées à la suite des données existentes, pour éviter les doublons, il faut s'assurer d'appeler truncateTable() de toutes les tables concernées.
	   $options = array('command' => 'doctrine:fixtures:load',"--append" => true);
	   $application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
	   
    }
    
    private function getEntityFromNameId($entity, $nameId) {
	   return $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:'.$entity)
		  ->findOneByNameId($nameId);
    }
    
    private function updateFeatPrerequisites() {
	   
	   // Mise à jour des liens entre les dons
	   foreach ($this->metadatas as $metadatas) {
		  foreach ($metadatas as $metadata) {
	   
			 $feat_repository = $this->getDoctrine()->getRepository('IcoRulesBundle:Feat');
			 if ($metadata['type'] == 'other') {
				$link = '';
				if (isset($metadata['otherType']) && $metadata['otherType'] == 'ExoticWeaponProficiency') {
				    $link = '';
				}
			 } elseif ($metadata['type'] == 'bba') {
				$link = '';
			 } elseif ($metadata['type'] == 'attribute') {
				$link = '';
			 } elseif ($metadata['type'] == 'race') {
				$link = '';
			 } elseif ($metadata['type'] == 'classLevel') {
				$link = '';
			 } elseif ($metadata['type'] == 'ClassPower') {
				$link = '';
			 } elseif ($metadata['type'] == 'skillRank') {
				$link = '';
			 } elseif ($metadata['type'] == 'spellCast') {
				$link = '';
			 } elseif ($metadata['type'] == 'feat') {
				$feat = $feat_repository->findOneByNameId($metadata['value']);
				if ($feat) {
				    $link = $this->getContainer()->get('router')->generate('ico_rules_feat_view', array('id' => $feat->getId()));
				}
			 }
			 $em = $this->getDoctrine()->getManager();
			 $feat_prerequisite = new FeatPrerequisite();
			 $feat_prerequisite->setName($metadata['html']);
			 $feat_prerequisite->setLink($link);
			 $feat_prerequisite->setFeat($feat_repository->findOneByNameId($metadata['feat']));
			 $em->persist($feat_prerequisite);
		  }
	   }
	   $em->flush();
    }
    
    protected function getDoctrine() {
	   return $this->getContainer()->get('doctrine');
    }
    
}