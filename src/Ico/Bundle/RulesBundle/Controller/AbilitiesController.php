<?php

namespace Ico\Bundle\RulesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class AbilitiesController extends Controller
{
    /**
     * @Route("/règles-pathfinder/caractéristiques", name="ico_rules_abilities")
     * @Template()
     */
    public function indexAction(Request $request)
    {	   	   	   
	   $abilities = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:Ability')
		  ->findAll();
	   
        return $this->render('IcoRulesBundle:Abilities:index.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles Pathfinder' => 'ico_rules', 
			 'Caractéristiques' => 'ico_rules_abilities'
		  ),
		  'title' => 'Caractéristiques',
		  'subtitle' => 'Liste',
		  'list' => $abilities
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder/caractéristiques/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_abilities_view", options={"expose"=true})
     * @Template()
     */
    public function viewAction($id)
    {
	   $ability = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:Ability')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:Abilities:view.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles Pathfinder' => 'ico_rules', 
			 'Caractéristiques' => 'ico_rules_abilities',
			 $ability->getName() => ''
		  ),
		  'title' => 'Caractéristique',
		  'subtitle' => ucfirst($ability->getName()),
		  'ability' => $ability
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder-aperçu/caractéristiques/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_abilities_preview", options={"expose"=true})
     * @Template()
     */
    public function previewAction($id)
    {
	   $ability = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:Ability')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:Abilities:preview.html.twig', array(
		  'ability' => $ability
	   ));
    }
}
