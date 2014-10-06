<?php

namespace Ico\Bundle\RulesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class SpellSchoolsController extends Controller
{
    /**
     * @Route("/rules/spellschools", name="ico_rules_spellschools")
     * @Template()
     */
    public function indexAction(Request $request)
    {	   	   	   
	   $spell_schools = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:SpellSchool')
		  ->findAll();
	   
        return $this->render('IcoRulesBundle:SpellSchools:index.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles' => 'ico_rules', 
			 'Sorts' => 'ico_rules_spells',
			 'Écoles' => 'ico_rules_spellschools'
		  ),
		  'title' => 'Écoles de magie',
		  'subtitle' => 'Liste',
		  'list' => $spell_schools
	   ));
    }
    
    /**
     * @Route("/rules/spellschools/view/{id}", name="ico_rules_spellschools_view", options={"expose"=true})
     * @Template()
     */
    public function viewAction($id)
    {
	   $spell_school = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:SpellSchool')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:SpellSchools:view.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles' => 'ico_rules', 
			 'Sorts' => 'ico_rules_spells',
			 'École de magie' => 'ico_rules_spellschools',
			 $spell_school->getName() => ''
		  ),
		  'title' => 'École de magie',
		  'subtitle' => $spell_school->getName(),
		  'spellschool' => $spell_school
	   ));
    }
    
    /**
     * @Route("/rules/spellschools/preview/{id}", name="ico_rules_spellschools_preview", options={"expose"=true})
     * @Template()
     */
    public function previewAction($id)
    {
	   $spell_school = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:SpellSchool')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:SpellSchools:preview.html.twig', array(
		  'spellschool' => $spell_school
	   ));
    }
}
