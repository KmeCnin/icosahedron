<?php

namespace Ico\Bundle\ParserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
//use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;
//use Symfony\Component\HttpFoundation\Request;
use Ico\Bundle\RulesBundle\Entity\Feat;
use Ico\Bundle\RulesBundle\Entity\FeatPrerequisite;
use Ico\Bundle\RulesBundle\Entity\Spell;
use Ico\Bundle\RulesBundle\Entity\SpellListLevel;
use Ico\Bundle\RulesBundle\Entity\BattleTime;
use Ico\Bundle\RulesBundle\Entity\Link;

class UpdateRulesCommand extends ContainerAwareCommand {

    protected $updateOnlyFixtures = false;
    protected $updateFeats = true;
    protected $updateSpells = true;
    protected $output;
    protected $metadatas;
    protected $currentFeat;
    protected $maxEntitiesStacked = 100; // Number of entities to persist before to flush them
    protected $root = '{{ROOT}}';
    protected $urlTranslator;
    protected $listUrlUsed = array();

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

    protected function execute(InputInterface $input, OutputInterface $output) {
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
			 $feats = $this->updateFeats();
			 $this->output->writeln(sprintf("<info>\t%d feats updated.</info>", count($feats)));
		  }
		  if ($this->updateSpells) {
			 $this->output->writeln(sprintf("<info>\tLoading Spells...</info>"));
			 $spells = $this->updateSpells();
			 $this->output->writeln(sprintf("<info>\t%d spells updated.</info>", count($spells)));
		  }

		  $this->output->writeln('Data updated.');
	   }

	   // Création des tables de correspondance pour inclure les liens locaux dans les descriptions
	   $this->output->writeln(sprintf("<info>Creating table of translate for wiki-url to local-url...</info>"));
	   $this->urlTranslatorInit();
	   $this->output->writeln(sprintf("<info>Table of translate created.</info>"));

	   $this->output->writeln(sprintf("<info>Creating links into descriptions...</info>"));
	   // On peut mettre à jour les liens dans les textes
	   $em = $this->getDoctrine()->getManager();
	   // Fixtures
	   foreach ($this->getFixturesEntities() as $entity_name) {
		  $entities = $this->getDoctrine()
				->getRepository('IcoRulesBundle:' . $entity_name)
				->findAll();
		  foreach ($entities as $entity) {
			 if (method_exists($entity, 'setDetail') && is_callable(array($entity, 'setDetail'))) {
				$entity->setDetail($this->replaceWithMyLinks($entity->getDetail()));
				$em->persist($entity);
			 }
		  }
		  $em->flush();
	   }
	   // Feats
	   $feats = $this->getDoctrine()
			 ->getRepository('IcoRulesBundle:Feat')
			 ->findAll();
	   foreach ($feats as $feat) {
		  $feat->setBenefit($this->replaceWithMyLinks($feat->getBenefit()));
		  $em->persist($feat);
	   }
	   $em->flush();
	   // Spells
	   $spells = $this->getDoctrine()
			 ->getRepository('IcoRulesBundle:Spell')
			 ->findAll();
	   foreach ($spells as $spell) {
		  $spell->setDetail($this->replaceWithMyLinks($spell->getDetail()));
		  $spell->setDuration($this->replaceWithMyLinks($spell->getDuration()));
		  $em->persist($spell);
	   }
	   $em->flush();
	   $this->output->writeln(sprintf("<info>Links created.</info>"));
//	   file_put_contents('D:/wamp/www/all_url_used.txt', print_r($this->listUrlUsed, true));
    }

    private function encode($string) {
	   return mb_convert_encoding($string, 'CP850', 'UTF-8');
    }

    private function updateFeats() {
	   $url = 'http://db.pathfinder-fr.org/raw/feats.xml';
	   $crawler = new Crawler;
	   $crawler->addHTMLContent(file_get_contents($url), 'UTF-8');
	   $em = $this->getDoctrine()->getManager();
	   $feats = $crawler->filter('feat')->each(function (Crawler $node) {
		  set_time_limit(50);
		  $em = $this->getDoctrine()->getManager();
		  $feat = new Feat();
		  $this->currentFeat = $node->attr('id');
		  $feat->setNameId($node->attr('id'));
		  $feat->setName($node->attr('name'));
		  $references = array();
		  $references = $node->filter('reference')->each(function(Crawler $ref) {
			 return $ref->attr('href');
		  });
		  $wikiUrl = $this->normalizeWikiUrl($references[0]);
		  foreach ($references as $url) {
			 $data = parse_url($url);
			 $source = $this->getDoctrine()
				    ->getRepository('IcoRulesBundle:LinkSource')
				    ->findOneByDomain($data['host']);
			 $link = new Link();
			 $link->setSource($source);
			 $link->setUrl($url);
			 $feat->addLink($link);
		  }
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
//		  if ($node->filter('benefit')->count() > 0) {
//			 $feat->setBenefit($node->filter('benefit')->text());
//		  } else {
//			 $feat->setBenefit($feat->getDescription());
//		  }
		  // Récupération des infos détaillées sur la page du wiki
		  $wikiCrawler = new Crawler;
		  $wikiCrawler->addHTMLContent(file_get_contents($wikiUrl), 'UTF-8');
		  $wikiContent = $wikiCrawler->filter('#PageContentDiv');
		  $htmlDescrition = $this->html($wikiContent);
		  $fragments = explode('<b>Avantage.</b>', $htmlDescrition, 2);
		  if (!isset($fragments[1])) {
			 $fragments = explode('<b>Avantages.</b>', $htmlDescrition, 2);
			 if (!isset($fragments[1])) {
				$fragments = explode('<b>Avantage</b>', $htmlDescrition, 2);
				if (!isset($fragments[1])) {
				    $fragments = explode('<b>Avantages</b>', $htmlDescrition, 2);
				}
			 }
		  }
		  $rawDescription = $fragments[1];
//		  $rawDescription = substr($rawDescription, 0, -10); // Suppression de la fin du html résiduel
		  $feat->setBenefit('<div>' . $rawDescription);

		  $em->persist($feat);
		  if (count($em->getUnitOfWork()->getScheduledEntityInsertions()) > $this->maxEntitiesStacked) {
			 $em->flush();
			 $this->output->writeln(sprintf("\t\t***** SAVEPOINT *****"));
		  }
		  $this->output->writeln(sprintf(chr(8) . "<info>\t\t%s</info>", $this->encode($feat->getName())));
		  return $feat;
	   });
	   $em->flush();
	   $this->output->writeln(sprintf("<info>\tCreating related links...</info>"));
	   // Mise à jour des liens sur les dons
	   $this->updateFeatPrerequisites();
	   $this->output->writeln(sprintf("<info>\tLinks created.</info>"));
	   return $feats;
    }

    private function updateSpells() {
	   $url = 'http://db.pathfinder-fr.org/raw/spells.xml';
	   $crawler = new Crawler;
	   $crawler->addHTMLContent(file_get_contents($url), 'UTF-8');
	   $em = $this->getDoctrine()->getManager();
	   $spells = $crawler->filter('spell')->each(function (Crawler $node) {
		  set_time_limit(100);
//	   if ($node->filter('name')->text() == 'Augure') {
		  $em = $this->getDoctrine()->getManager();
		  $spell = new Spell();
		  $this->current_spell = $node->attr('id');
		  $spell->setNameId($this->nameIdFromName($node->filter('name')->text()));
		  $spell->setName($node->filter('name')->text());
		  $references = array();
		  $references = $node->filter('reference')->each(function(Crawler $ref) {
			 return $ref->attr('href');
		  });
		  $wikiUrl = $this->normalizeWikiUrl($references[0]);
		  foreach ($references as $url) {
			 $data = parse_url($url);
			 $source = $this->getDoctrine()
				    ->getRepository('IcoRulesBundle:LinkSource')
				    ->findOneByDomain($data['host']);
			 $link = new Link();
			 $link->setSource($source);
			 $link->setUrl($url);
			 $spell->addLink($link);
		  }
		  if ($node->filter('summary')->count() > 0) {
			 $spell->setDescription($node->filter('summary')->text());
		  } else {
			 $spell->setDescription('');
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
				$spell->setRangeSpecial((int) $node->filter('range')->text() * 1.5 . ' m (' . ($node->filter('range')->text()) . ' c)');
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
		  if ($node->filter('savingThrow')->count() > 0) {

			 // Création du lien vers l'effet (inoffensif)
			 $inoffensif = $this->getEntityFromNameId('SavingThrowEffect', 'inoffensif');
			 $url = $this->root . $this->getContainer()->get('router')->generate('ico_rules_savingthroweffects_view', array('id' => $inoffensif->getId(), 'slug' => $inoffensif->getSlug()));
			 $saving_throw_special = preg_replace('/inoffensif/i', '<a class="preview" href="' . $url . '">inoffensif</a>', $node->filter('savingThrow')->text());

			 // Création du lien vers l'effet (objet)
			 $objet = $this->getEntityFromNameId('SavingThrowEffect', 'objet');
			 $url = $this->root . $this->getContainer()->get('router')->generate('ico_rules_savingthroweffects_view', array('id' => $objet->getId(), 'slug' => $objet->getSlug()));
			 $saving_throw_special = preg_replace('/objet/i', '<a class="preview" href="' . $url . '">objet</a>', $saving_throw_special);

			 $spell->setSavingThrowSpecial($saving_throw_special);
			 if ($node->filter('savingThrow')->attr('target') != 'none') {
				$spell->setSavingThrow($this->getEntityFromNameId('SavingThrow', $node->filter('savingThrow')->attr('target')));
				if ($node->filter('savingThrow')->attr('effect') != 'none') {
				    $spell->setSavingThrowEffect($this->getEntityFromNameId('SavingThrowEffect', $node->filter('savingThrow')->attr('effect')));
				}
			 }
		  }
		  // Récupération des infos détaillées sur la page du wiki
		  $wikiCrawler = new Crawler;
		  $wikiCrawler->addHTMLContent(file_get_contents($wikiUrl), 'UTF-8');
		  $wikiContent = $wikiCrawler->filter('#PageContentDiv');
		  $htmlDescrition = $this->html($wikiContent);
		  $fragments = explode('<br><br>', $htmlDescrition, 2);
		  $rawDescription = $fragments[1];
//		  $rawDescription = substr($rawDescription, 0, -10); // Suppression de la fin du html résiduel
		  $spell->setDetail('<div>' . $rawDescription);

		  // Récupération de la durée
		  $results = array();
		  preg_match('/<b>Durée<\/b>(.*)<\s?\/?br\s?\/?>/U', $htmlDescrition, $results);
		  if (!isset($results[1])) {
			 preg_match('/<b>Durée<\/b>(.*)/', $htmlDescrition, $results);
		  }
		  $spell->setDuration($results[1]);

		  $em->persist($spell);
		  // On flush si jamais le buffer est trop rempli pour éviter un dépacement de mémoire
		  if (count($em->getUnitOfWork()->getScheduledEntityInsertions()) > $this->maxEntitiesStacked) {
			 $em->flush();
			 $this->output->writeln(sprintf("\t\t***** SAVEPOINT *****"));
		  }
		  $this->output->writeln(sprintf("<info>\t\t%s</info>", $this->encode($spell->getName())));

		  return $spell;
//	   }
	   });
	   $em->flush();
	   return $spells;
    }

    protected function normalizeWikiUrl($rawUrl) {

	   $arrayUrl = explode('/', $rawUrl);
	   $arrayUrl[count($arrayUrl) - 1] = rawurlencode($arrayUrl[count($arrayUrl) - 1]);
	   return implode('/', $arrayUrl);
    }

    public function html($wikiContent) {
	   $htmlDescrition = '';
	   foreach ($wikiContent as $domElement) {
		  $htmlDescrition .= $domElement->ownerDocument->saveHTML($domElement);
	   }
	   return $htmlDescrition;
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
		  'IcoKingmakerBundle:MapModel',
		  'IcoKingmakerBundle:MapInterestModel',
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
	   if (!$this->updateOnlyFixtures) {
		  $tablesToTruncate[] = 'IcoRulesBundle:Link';
	   }
	   // Tables à vider seulement si on synchronise les dons
	   if ($this->updateFeats) {
		  $tablesToTruncate[] = 'IcoRulesBundle:Feat';
		  $tablesToTruncate[] = 'feat_feattype';
		  $tablesToTruncate[] = 'IcoRulesBundle:FeatPrerequisite';
		  $tablesToTruncate[] = 'feat_link';
		  $tablesToTruncate[] = 'feat_parents_feat_children';
	   }
	   // Tables à vider seulement si on synchronise les sorts
	   if ($this->updateSpells) {
		  $tablesToTruncate[] = 'IcoRulesBundle:Spell';
		  $tablesToTruncate[] = 'IcoRulesBundle:SpellListLevel';
		  $tablesToTruncate[] = 'IcoRulesBundle:BattleTime';
		  $tablesToTruncate[] = 'spell_spellcomponent';
		  $tablesToTruncate[] = 'spell_spelllistlevel';
		  $tablesToTruncate[] = 'spell_link';
	   }
	   return $tablesToTruncate;
    }

    public function loadFixtures() {
	   $kernel = $this->getContainer()->get('kernel');
	   $application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
	   $application->setAutoExit(false);
	   // Les fixtures sont chargées à la suite des données existentes, pour Ã©viter les doublons, il faut s'assurer d'appeler truncateTable() de toutes les tables concernées.
	   $options = array('command' => 'doctrine:fixtures:load', "--append" => true);
	   $application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
    }

    private function getEntityFromNameId($entity, $nameId) {
	   return $this->getDoctrine()
				    ->getRepository('IcoRulesBundle:' . $entity)
				    ->findOneByNameId($nameId);
    }

    private function getEntityFromName($entity, $name) {
	   return $this->getDoctrine()
				    ->getRepository('IcoRulesBundle:' . $entity)
				    ->findOneByName($name);
    }

    private function updateFeatPrerequisites() {
	   // Mise à jour des liens entre les dons
	   foreach ($this->metadatas as $metadatas) {
		  foreach ($metadatas as $metadata) {
			 $em = $this->getDoctrine()->getManager();
			 $feat_repository = $this->getDoctrine()->getRepository('IcoRulesBundle:Feat');
			 $spell_repository = $this->getDoctrine()->getRepository('IcoRulesBundle:Spell');
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
				$spell = $spell_repository->findOneByNameId($metadata['value']);
				if ($spell) {
				    $link = $this->root . $this->getContainer()->get('router')->generate('ico_rules_spell_view', array('id' => $spell->getId(), 'slug' => $spell->getSlug()));
				}
			 } elseif ($metadata['type'] == 'feat') {
				$feat = $feat_repository->findOneByNameId($metadata['value']);
				if ($feat) {

				    $link = $this->root . $this->getContainer()->get('router')->generate('ico_rules_feat_view', array('id' => $feat->getId(), 'slug' => $feat->getSlug()));
				    // Définition du lien de parenté pour l'arborescence de dons
				    $feat_parent = $feat_repository->findOneByNameId($metadata['feat']);

				    // Arborescence montante
				    $feat_parent->addParent($feat);
				    $em->persist($feat_parent);

				    // Arborescence descendante
				    $feat->addChild($feat_parent);
				    $em->persist($feat);
				}
			 }
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

    protected function collectUrlUsed($html) {
	   $pattern = '/<a\s[^>]*href=\"([^\"]*)\"[^>]*>.*<\/a>/siU';
	   $matches = array();
	   preg_match($pattern, $html, $matches, PREG_OFFSET_CAPTURE, 3);
	   foreach ($matches as $index => $match) {
		  if ($index != 0 && !in_array($match[0], $this->listUrlUsed)) {
			 $this->listUrlUsed[] = $match[0];
		  }
	   }
	   sort($this->listUrlUsed);
    }

    protected function replaceWithMyLinks($text) {

//	   $this->collectUrlUsed($text);
	   // Change all wiki class "pagelink" to local class "preview"
	   $text = str_replace('pagelink', 'preview', $text);
	   // Removing title attributes
	   $text = preg_replace('/(<[^>]+) title=".*?"/i', '$1', $text);
	   // replace all wiki-url into local-url
	   return str_replace(array_keys($this->urlTranslator), $this->urlTranslator, $text);
    }

    protected function nameIdFromName($name) {

	   $lowercasedName = strtolower($name);
	   $dashedName = preg_replace('/ /', '-', $lowercasedName);
	   $uncotedName = preg_replace('/\'/', '', $dashedName);
	   return $uncotedName;
    }

    protected function fileNameFromUrl($url) {
	   // Les fichiers sont nommés en se basant sur le nom de la page, en remplaçant les espaces par des tirets et en mettant en majuscule la première lettre de chaque mot
	   $endUrl = substr($url, strrpos($url, "/") + 1);
	   $spacedUrl = preg_replace('/%20/', ' ', $endUrl);
	   $unprefixedUrl = preg_replace('/^Pathfinder-RPG./', '', $spacedUrl);
	   $xmledUrl = preg_replace('/ashx/', 'xml', $unprefixedUrl);
	   $uppercasedUrl = ucwords($xmledUrl);
	   $fileName = preg_replace('/ /', '-', $uppercasedUrl);
	   $convertedName = mb_convert_encoding($fileName, 'Windows-1252', 'UTF-8');
	   return $this->getContainer()->get('kernel')->getRootDir() . '/../web/wiki-pathfinder/' . $convertedName;
    }

    protected function urlFromFileName($fileName) { // TODO
	   // Les fichiers sont nommés en se basant sur le nom de la page, en remplaçant les espaces par des tirets et en mettant en majuscule la première lettre de chaque mot
	   $convertedName = rawurlencode(mb_convert_encoding($fileName, 'UTF-8', 'Windows-1252'));
	   $spacedName = preg_replace('/-/', ' ', $convertedName);
	   $lowercasedUrl = strtolower($spacedName);
	   $ashxedUrl = preg_replace('/xml/', 'ashx', $lowercasedUrl);
	   $prefixedUrl = 'Pathfinder-RPG.' . $ashxedUrl;
	   $normalizedUrl = preg_replace('/ /', '%20', $prefixedUrl);
	   return $normalizedUrl;
    }

    protected function urlTranslatorInit() {
	   // Récupération de la liste des pages
	   $path = 'D:/wamp/www/Pathfinder-RPG/';
	   $pages = array();
	   foreach (new \DirectoryIterator($path) as $fileInfo) {
		  if ($fileInfo->isDot()) {
			 continue;
		  }
		  $pages[] = $fileInfo->getFilename();
	   }
	   // Url exceptionnelles
	   $specials_urls = array(
		  array(
			 'raw' => 'round',
			 'route' => 'battleunits',
			 'id' => 7,
			 'slug' => 'round'
		  ),
	   );
	   //  Url des compétences
	   $skills = $this->getDoctrine()
			 ->getRepository('IcoRulesBundle:Skill')
			 ->findAll();
	   foreach ($skills as $skill) {
		  $specials_urls[] = array(
			 'raw' => ucfirst(strtolower(rawurlencode($skill->getName()))),
			 'route' => 'skills',
			 'id' => $skill->getId(),
			 'slug' => $skill->getSlug()
		  );
	   }
	   foreach ($specials_urls as $data) {
		  $this->urlTranslator['Pathfinder-RPG.' . $data['raw'] . '.ashx'] = $this->root . $this->getContainer()->get('router')->generate('ico_rules_' . $data['route'] . '_view', array('id' => $data['id'], 'slug' => $data['slug']));
	   }
	   foreach ($pages as $page) {
		  set_time_limit(50);
		  // Url correspondant à des fichiers
		  $crawler = new Crawler;
		  $crawler->addHTMLContent(file_get_contents($path . $page), 'UTF-8');
		  $categories = $crawler->filter('category')->each(function (Crawler $category) {
			 return $category->text();
		  });
		  $catToRoute = array(
			 'Pathfinder-RPG.Sort' => 'spell',
			 'Pathfinder-RPG.Don' => 'feat'
		  );
		  foreach ($categories as $category) {
			 foreach ($catToRoute as $cat => $entityName) {
				if ($category == $cat) {
				    $entity = $this->getEntityFromName(ucfirst($entityName), $crawler->filter('title')->text());
				    if ($entity) {
					   $this->urlTranslator[$this->urlFromFileName($page)] = $this->root . $this->getContainer()->get('router')->generate('ico_rules_' . $entityName . '_view', array('id' => $entity->getId(), 'slug' => $entity->getSlug()));
				    }
				}
			 }
		  }
//		  file_put_contents('D:/wamp/www/urlTranslator.txt', print_r($this->urlTranslator, true));
	   }
    }

}
