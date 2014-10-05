<?php

namespace Ico\Bundle\RulesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\StreamedResponse;

use Ico\Bundle\RulesBundle\Entity\Feat;
use Ico\Bundle\RulesBundle\Entity\FeatPrerequisite;
use Ico\Bundle\RulesBundle\Entity\Spell;
use Ico\Bundle\RulesBundle\Helper\FlushHelper;

class AdminController extends Controller
{
    private $metadatas;
    private $helper;
    private $current_feat;
    
    /**
     * @Route("/admin/rules", name="ico_admin_rules")
     * @Template()
     */
    public function indexAction(Request $request)
    {
	   $form = $this->createFormBuilder()
			 ->add('feats', 'checkbox', array('label' => 'Dons', 'required' => false, 'attr' => array('checked' => 'checked')))
			 ->add('spells', 'checkbox', array('label' => 'Sorts', 'required' => false, 'attr' => array('checked' => 'checked')))
			 ->getForm();
	   $form->handleRequest($request);
	   
	   if ($form->isValid()) {
		  return $this->forward('IcoRulesBundle:Admin:rulesUpdate', array('data' => $form->getData()));
	   }
	   
	   return $this->render('IcoRulesBundle:Admin:index.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles' => 'ico_rules'
		  ),
		  'title' => 'Administration',
		  'subtitle' => 'Synchroniser les données',
		  'form' => $form->createView()
	   ));
    }
   
    /**
     * @Route("/admin/rules_update", name="ico_admin_rules_update")
     * @Template()
     */
    public function rulesUpdateAction($data)
    {	 	   
	   $this->helper = new FlushHelper();
	   $this->get('session')->getFlashBag()->add('success', 'La base de données a été synchronisée.');

        return new StreamedResponse(function() use($data) {
		  
            $top = $this->renderView('IcoRulesBundle:StreamDemo:top.html.twig');
            $this->helper->out($top);
		  
		  $this->helper->consoleUpdate('Suppression des anciennes données...');		  
		  // On vide les tables
		  // Tables à vider toujours (car elles sont rechargées par les fixtures)
		  $tablesToTruncate = array('IcoRulesBundle:FeatType', 'IcoRulesBundle:SpellSchool', 'IcoRulesBundle:SpellComponent', 'IcoRulesBundle:SpellList');
		  // Tables à vider seulement si on synchronise les dons
		  if ($data['feats']) {
			 $tablesToTruncate[] = 'IcoRulesBundle:Feat';
			 $tablesToTruncate[] = 'feat_feattype';
			 $tablesToTruncate[] = 'IcoRulesBundle:FeatPrerequisite';
		  }
		  // Tables à vider seulement si on synchronise les sorts
		  if ($data['spells']) {
			 $tablesToTruncate[] = 'IcoRulesBundle:Spell';
		  }
		  foreach ($tablesToTruncate as $className) {
			 $this->truncateTable($className);
			 $this->helper->consoleUpdate('	'.$className.' supprimé');
		  }
		  $this->helper->consoleUpdate('Anciennes données supprimées.');	
		  $this->helper->consoleUpdate('');	

		  $this->helper->consoleUpdate('Chargement des fixtures...');		
		  // On charge les fixtures
		  $kernel = $this->get('kernel');
		  $application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
		  $application->setAutoExit(false);
		  $options = array('command' => 'doctrine:fixtures:load',"--append" => true);
		  $application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
		  $this->helper->consoleUpdate('Fixtures chargées.');	
		  $this->helper->consoleUpdate('');	

		  // On récupère les nouvelles infos
		  $logs = array();
		  $this->helper->consoleUpdate('Récupération des nouvelles données :');
		  if ($data['feats']) {
			 $this->helper->consoleUpdate('	Chargement des dons...');	
			 $logs['Dons synchronisés'] = $this->updateFeats();
			 $this->helper->consoleUpdate('	'.count($logs['Dons synchronisés']).' dons récupérés.');	
		  }
		  if ($data['spells']) {
			 $this->helper->consoleUpdate('	Chargement des sorts...');	
			 $logs['Sorts synchronisés'] = $this->updateSpells();
			 $this->helper->consoleUpdate('	'.count($logs['Sorts synchronisés']).' sorts récupérés.');
		  }
		  $this->helper->consoleUpdate('Les données sont à jour.');
		  $this->helper->consoleClose($this->get('router')->generate('ico'));

            echo $this->renderView('IcoRulesBundle:StreamDemo:bottom.html.twig');

        });
    }
    
    private function truncateTable($className) {
	   
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
    
    private function normalizeCase($string) {
	   // Change les majuscules accentuées en majuscules normales
	   $accentuated = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Œ', 'Ù', 'Ú', 'Û', 'Ü');
	   $normalized = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'OE', 'U', 'U', 'U', 'U');
	   return str_replace($accentuated, $normalized, $string);
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
				    $link = $this->get('router')->generate('ico_rules_feat_view', array('id' => $feat->getId()));
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
    
    private function updateFeats() {
	   $url = 'http://db.pathfinder-fr.org/raw/feats.xml';
	   $crawler = new Crawler;
	   $crawler->addHTMLContent(file_get_contents($url), 'UTF-8');
	   $em = $this->getDoctrine()->getManager();
	   $logs = $crawler->filter('feat')->each(function (Crawler $node) {
		  set_time_limit(10) ;
		  $em = $this->getDoctrine()->getManager();
		  $feat = new Feat(); 
		  $this->current_feat = $node->attr('id');
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
			 $metadata['feat'] = $this->current_feat;
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
		  $this->helper->consoleUpdate('		'.$feat->getName());
		  return $feat->getName();
	   });
	   $em->flush();
	   
	   $this->helper->consoleUpdate('	Création des liens...');	
	   // Mise à jour des liens sur les dons
	   $this->updateFeatPrerequisites();
	   $this->helper->consoleUpdate('	Liens mis à jour.');
	   
	   return $logs;
    }
    
    private function updateSpells() {
	   $url = 'http://db.pathfinder-fr.org/raw/spells.xml';
	   $crawler = new Crawler;
	   $crawler->addHTMLContent(file_get_contents($url), 'UTF-8');
	   $em = $this->getDoctrine()->getManager();
	   $logs = $crawler->filter('spell')->each(function (Crawler $node) {
		  set_time_limit(10) ;
		  $em = $this->getDoctrine()->getManager();
		  $spell = new Spell(); 
		  $this->current_spell = $node->attr('id');
		  $spell->setNameId($node->attr('id'));
		  $spell->setName($node->filter('name')->text());
		  $spell->setWiki($node->filter('reference')->eq(0)->attr('href'));
		  if ($node->filter('summary')->count() > 0) {
			 $spell->setDescription($node->filter('summary')->text());
		  } else {
			 $spell->setDescription('');
		  }
		  if ($node->filter('target')->count() > 0) {
			 $spell->setTarget($node->filter('target')->text());
		  }
		  $spell->setSpellSchool($this->getEntityFromNameId('SpellSchool', $node->attr('school')));
//		  $spell_schools = $node->filter('type')->each(function (Crawler $type) {
//			 return $this->getSpellSchoolFromName($type->text());
//		  });
//		  $metadatas = $node->filter('prerequisite')->each(function (Crawler $prerequisite) {
//			 $metadata = array();
//			 $metadata['html'] = $prerequisite->text();
//			 $metadata['feat'] = $this->current_feat;
//			 $metadata['type'] = $prerequisite->attr('type');
//			 if ($prerequisite->attr('type') == 'other') {
//				if ($prerequisite->attr('otherType') > 0 && $prerequisite->attr('otherType') == 'ExoticWeaponProficiency') {
//				    $metadata['otherType'] = $prerequisite->attr('otherType');
//				    $metadata['value'] = $prerequisite->attr('value');
//				}
//			 } elseif ($prerequisite->attr('type') == 'bba') {
//				$metadata['number'] = $prerequisite->attr('number');
//			 } elseif ($prerequisite->attr('type') == 'attribute') {
//				$metadata['value'] = $prerequisite->attr('value');
//				$metadata['number'] = $prerequisite->attr('number');
//			 } elseif ($prerequisite->attr('type') == 'race') {
//				$metadata['value'] = $prerequisite->attr('value');
//			 } elseif ($prerequisite->attr('type') == 'classLevel') {
//				$metadata['value'] = $prerequisite->attr('value');
//				$metadata['number'] = $prerequisite->attr('number');
//			 } elseif ($prerequisite->attr('type') == 'ClassPower') {
//				$metadata['value'] = $prerequisite->attr('value');
//			 } elseif ($prerequisite->attr('type') == 'skillRank') {
//				$metadata['value'] = $prerequisite->attr('value');
//				$metadata['number'] = $prerequisite->attr('number');
//			 } elseif ($prerequisite->attr('type') == 'spellCast') {
//				$metadata['value'] = $prerequisite->attr('value');
//			 } elseif ($prerequisite->attr('type') == 'feat') {
//				$metadata['value'] = $prerequisite->attr('value');
//			 }
//			 return $metadata;
//		  });
//		  $this->metadatas[] = $metadatas;
//		  foreach ($spell_schools as $spell_school) {
//			 $spell->addSpellSchool($spell_school);
//		  }
//		  if ($node->filter('benefit')->count() > 0) {
//			 $feat->setBenefit($node->filter('benefit')->text());
//		  } else {
//			 $feat->setBenefit($feat->getDescription());
//		  }
		  $em->persist($spell);
		  $this->helper->consoleUpdate('		'.$spell->getName());
		  return $spell->getName();
	   });
	   $em->flush();
	   
	   return $logs;
    }
}
