<?php

namespace Ico\Bundle\RulesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DomCrawler\Crawler;
use Ico\Bundle\RulesBundle\Entity\Feat;
use Ico\Bundle\RulesBundle\Entity\FeatPrerequisite;

class AdminController extends Controller
{
    private $metadatas;
    private $current_feat;
    
    /**
     * @Route("/admin/rules_update", name="ico_admin_rules_update")
     * @Template()
     */
    public function rulesUpdateAction(Request $request)
    {	
	   $this->get('session')->getFlashBag()->add('success', 'La base de données de rêgles a été synchronisée.');
	   // On vide les tables
	   $tablesToTruncate = array('IcoRulesBundle:Feat', 'IcoRulesBundle:FeatType', 'IcoRulesBundle:FeatPrerequisite');
	   foreach ($tablesToTruncate as $className) {
		  $this->truncateTable($className);
	   }
	   
	   // On charge les fixtures
	   $kernel = $this->get('kernel');
	   $application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
	   $application->setAutoExit(false);
	   $options = array('command' => 'doctrine:fixtures:load',"--append" => true);
	   $application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
	   
	   // On récupère les nouvelles infos
	   $logs = array();
	   $logs['Dons synchronisés'] = $this->updateFeats();
	   
	   $this->get('session')->getFlashBag()->add('success', 'La base de données de règles a été synchronisée.');
        return $this->render('IcoRulesBundle:Admin:update.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico'
		  ),
		  'title' => 'Synchronisation terminée',
		  'subtitle' => 'Compte rendu',
		  'logs' => $logs
	   ));
    }
    
    private function truncateTable($className) {
	   $em = $this->getDoctrine()->getManager();
	   $cmd = $em->getClassMetadata($className);
	   $connection = $em->getConnection();
	   $dbPlatform = $connection->getDatabasePlatform();
	   $connection->beginTransaction();

	   try {
		  $connection->query('SET FOREIGN_KEY_CHECKS=0');
		  $q = $dbPlatform->getTruncateTableSql($cmd->getTableName());
		  $connection->executeUpdate($q);
		  $connection->query('SET FOREIGN_KEY_CHECKS=1');
		  $connection->commit();
	   } catch (\Exception $e) {
		  $connection->rollback();
	   }
    }
    
    private function normalizeCase($string) {
	   // Change les majuscules accentuées en majuscules normales
	   $accentuated = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Œ', 'Ù', 'Ú', 'Û', 'Ü');
	   $normalized = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'OE', 'U', 'U', 'U', 'U');
	   return str_replace($accentuated, $normalized, $string);
    }
    
    private function getFeatTypeFromName($name) {
	   return $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:FeatType')
		  ->findOneByNameId($name);
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
			 return $this->getFeatTypeFromName($type->text());
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
		  return $feat->getName();
	   });
	   $em->flush();
	   
	   // Mise à jour des liens sur les dons
	   $this->updateFeatPrerequisites();
	   
	   return $logs;
    }
}
