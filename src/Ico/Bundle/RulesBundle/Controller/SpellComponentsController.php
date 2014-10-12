<?php

namespace Ico\Bundle\RulesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class SpellComponentsController extends Controller
{
    /**
     * @Route("/rules/spellcomponents", name="ico_rules_spellcomponents")
     * @Template()
     */
    public function indexAction(Request $request)
    {	   	   	   
	   $spell_components = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:SpellComponent')
		  ->findAll();
	   
        return $this->render('IcoRulesBundle:SpellComponents:index.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles' => 'ico_rules', 
			 'Sorts' => 'ico_rules_spells',
			 'Composantes' => 'ico_rules_spellcomponents'
		  ),
		  'title' => 'Composantes de sorts',
		  'subtitle' => 'Liste',
		  'list' => $spell_components
	   ));
    }
    
    /**
     * @Route("/rules/spellcomponents/view/{id}", name="ico_rules_spellcomponents_view", options={"expose"=true})
     * @Template()
     */
    public function viewAction($id)
    {
	   $spell_component = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:SpellComponent')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:SpellComponents:view.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles' => 'ico_rules', 
			 'Sorts' => 'ico_rules_spells',
			 'Composantes' => 'ico_rules_spellcomponents',
			 $spell_component->getName() => ''
		  ),
		  'title' => 'Composantes de sorts',
		  'subtitle' => $spell_component->getName(),
		  'spellcomponent' => $spell_component
	   ));
    }
    
    /**
     * @Route("/rules/spellcomponents/preview/{id}", name="ico_rules_spellcomponents_preview", options={"expose"=true})
     * @Template()
     */
    public function previewAction($id)
    {
	   $spell_component = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:SpellComponent')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:SpellComponents:preview.html.twig', array(
		  'spellcomponent' => $spell_component
	   ));
    }
}
