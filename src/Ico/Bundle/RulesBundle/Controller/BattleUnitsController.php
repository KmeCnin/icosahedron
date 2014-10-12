<?php

namespace Ico\Bundle\RulesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class BattleUnitsController extends Controller
{
    /**
     * @Route("/rules/battleunits", name="ico_rules_battleunits")
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
			 'Règles' => 'ico_rules', 
			 'Types d\'actions' => 'ico_rules_battleunits'
		  ),
		  'title' => 'Types d\'actions',
		  'subtitle' => 'Liste',
		  'list' => $actions
	   ));
    }
    
    /**
     * @Route("/rules/battleunits/view/{id}", name="ico_rules_battleunits_view", options={"expose"=true})
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
			 'Règles' => 'ico_rules', 
			 'Types d\'actions' => 'ico_rules_battleunits',
			 $action->getName() => ''
		  ),
		  'title' => 'Type d\'action',
		  'subtitle' => ucfirst($action->getName()),
		  'action' => $action
	   ));
    }
    
    /**
     * @Route("/rules/battleunits/preview/{id}", name="ico_rules_battleunits_preview", options={"expose"=true})
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
