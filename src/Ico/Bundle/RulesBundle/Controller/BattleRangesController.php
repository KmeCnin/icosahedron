<?php

namespace Ico\Bundle\RulesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class BattleRangesController extends Controller
{
    /**
     * @Route("/règles-pathfinder/portées", name="ico_rules_battleranges")
     * @Template()
     */
    public function indexAction(Request $request)
    {	   	   	   
	   $ranges = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:BattleRange')
		  ->findAll();
	   
        return $this->render('IcoRulesBundle:BattleRanges:index.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles Pathfinder' => 'ico_rules', 
			 'Portées' => 'ico_rules_battleranges'
		  ),
		  'title' => 'Portées',
		  'subtitle' => 'Liste',
		  'list' => $ranges
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder/portées/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_battleranges_view", options={"expose"=true})
     * @Template()
     */
    public function viewAction($id)
    {
	   $range = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:BattleRange')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:BattleRanges:view.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles Pathfinder' => 'ico_rules', 
			 'Portées' => 'ico_rules_battleranges',
			 $range->getName() => ''
		  ),
		  'title' => ucfirst($range->getName()),
		  'subtitle' => 'Portée',
		  'range' => $range
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder-aperçu/portées/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_battleranges_preview", options={"expose"=true})
     * @Template()
     */
    public function previewAction($id)
    {
	   $range = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:BattleRange')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:BattleRanges:preview.html.twig', array(
		  'range' => $range
	   ));
    }
}
