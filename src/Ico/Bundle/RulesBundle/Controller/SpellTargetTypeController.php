<?php

namespace Ico\Bundle\RulesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class SpellTargetTypeController extends Controller
{
    /**
     * @Route("/règles-pathfinder/types-de-ciblage", name="ico_rules_spelltargettypes")
     * @Template()
     */
    public function indexAction(Request $request)
    {	   	   	   
	   $spelltargettype = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:SpellTargetType')
		  ->findAll();
	   
        return $this->render('IcoRulesBundle:SpellTargetTypes:index.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles' => 'ico_rules', 
			 'Sorts' => 'ico_rules_spells',
			 'Types de ciblage' => 'ico_rules_spelltargettypes'
		  ),
		  'title' => 'Types de ciblage',
		  'subtitle' => 'Liste',
		  'list' => $spelltargettype
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder/types-de-ciblage/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_spelltargettypes_view", options={"expose"=true})
     * @Template()
     */
    public function viewAction($id)
    {
	   $spelltargettype = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:SpellTargetType')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:SpellTargetTypes:view.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles' => 'ico_rules', 
			 'Sorts' => 'ico_rules_spells',
			 'Types de ciblage' => 'ico_rules_spelltargettypes',
			 $spelltargettype->getName() => ''
		  ),
		  'title' => 'Type de ciblage',
		  'subtitle' => $spelltargettype->getName(),
		  'spelltargettype' => $spelltargettype
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder-aperçu/types-de-ciblage/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_spelltargettypes_preview", options={"expose"=true})
     * @Template()
     */
    public function previewAction($id)
    {
	   $spelltargettype = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:SpellTargetType')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:SpellTargetTypes:preview.html.twig', array(
		  'spelltargettype' => $spelltargettype
	   ));
    }
}
