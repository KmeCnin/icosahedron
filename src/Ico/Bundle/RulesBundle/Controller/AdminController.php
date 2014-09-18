<?php

namespace Ico\Bundle\RulesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DomCrawler\Crawler;
use Ico\Bundle\RulesBundle\Entity\Feat;

class AdminController extends Controller
{
    /**
     * @Route("/admin/rules_update", name="ico_admin_rules_update")
     * @Template()
     */
    public function rulesUpdateAction(Request $request)
    {	
	   echo 'here';
	   $this->get('session')->getFlashBag()->add('success', 'La base de données de rêgles a été synchronisée.');
	   // On vide les tables
	   $tablesToTruncate = array('IcoRulesBundle:Feat');
	   foreach ($tablesToTruncate as $className) {
		  $this->truncateTable($className);
	   }
	   // On récupère les nouvelles infos
	   $this->updateFeats();
	   
	   $this->get('session')->getFlashBag()->add('success', 'La base de données de règles a été synchronisée.');
        return $this->render('IcoAppBundle::index.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico'
		  ),
		  'title' => 'Accueil',
		  'subtitle' => 'Bienvenue'
	   ));
    }
    
    private function truncateTable($className) {
	   $em = $this->getDoctrine()->getManager();
	   $cmd = $em->getClassMetadata($className);
	   $connection = $em->getConnection();
	   $connection->getDatabasePlatform();
	   $connection->beginTransaction();

	   try {
		  $connection->query('SET FOREIGN_KEY_CHECKS=0');
		  $connection->query('DELETE FROM '.$cmd->getTableName());
		  // Beware of ALTER TABLE here--it's another DDL statement and will cause
		  // an implicit commit.
		  $connection->query('SET FOREIGN_KEY_CHECKS=1');
		  $connection->commit();
	   } catch (\Exception $e) {
		  $connection->rollback();
	   }
    }
    
    private function updateFeats() {
	   $url = 'http://db.pathfinder-fr.org/raw/feats.xml';
	   $crawler = new Crawler;
	   $crawler->addHTMLContent(file_get_contents($url), 'UTF-8');
	   $em = $this->getDoctrine()->getManager();
	   $crawler->filter('feat')->each(function (Crawler $node) {
		  $em = $this->getDoctrine()->getManager();
		  $feat = new Feat(); 
		  $feat->setName($node->attr('name'));
		  $feat->setWiki($node->filter('reference')->eq(0)->attr('href'));
		  $feat->setDescription($node->filter('description')->text());
//		  		 $feat->setBenefit($node->filter('benefit')->text());
		  $feat->setBenefit('');
		  $em->persist($feat);
	   });
	   $em->flush();
    }
}
