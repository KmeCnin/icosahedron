<?php

namespace Ico\Bundle\RulesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class BattleUnitsController extends Controller
{
    /**
     * @Route("/règles-pathfinder/types-dactions", name="ico_rules_battleunits")
     * @Template()
     */
    public function indexAction(Request $request)
    {	   	   	   
	   $actions = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:BattleUnit')
		  ->findAll();
	   
        return $this->render('IcoRulesBundle:BattleUnits:index.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles Pathfinder' => 'ico_rules', 
			 'Types d\'actions' => 'ico_rules_battleunits'
		  ),
		  'title' => 'Types d\'actions',
		  'subtitle' => 'Liste',
		  'list' => $actions
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder/types-dactions/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_battleunits_view", options={"expose"=true})
     * @Template()
     */
    public function viewAction($id)
    {
	   $action = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:BattleUnit')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:BattleUnits:view.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles Pathfinder' => 'ico_rules', 
			 'Types d\'actions' => 'ico_rules_battleunits',
			 $action->getName() => ''
		  ),
		  'title' => ucfirst($action->getName()),
		  'subtitle' => 'Type d\'action',
		  'action' => $action
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder-aperçu/types-dactions/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_battleunits_preview", options={"expose"=true})
     * @Template()
     */
    public function previewAction($id)
    {
	   $action = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:BattleUnit')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:BattleUnits:preview.html.twig', array(
		  'action' => $action
	   ));
    }
}
