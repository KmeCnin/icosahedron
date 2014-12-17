<?php

namespace Ico\Bundle\RulesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class SpellSchoolsController extends Controller
{
    /**
     * @Route("/règles-pathfinder/écoles-de-magie", name="ico_rules_spellschools")
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
			 'Règles Pathfinder' => 'ico_rules', 
			 'Sorts' => 'ico_rules_spells',
			 'Écoles' => 'ico_rules_spellschools'
		  ),
		  'title' => 'Écoles de magie',
		  'subtitle' => 'Liste',
		  'list' => $spell_schools
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder/écoles-de-magie/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_spellschools_view", options={"expose"=true})
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
			 'Règles Pathfinder' => 'ico_rules', 
			 'Sorts' => 'ico_rules_spells',
			 'École de magie' => 'ico_rules_spellschools',
			 $spell_school->getName() => ''
		  ),
		  'title' => $spell_school->getName(),
		  'subtitle' => 'École de magie',
		  'spellschool' => $spell_school
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder-aperçu/écoles-de-magie/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_spellschools_preview", options={"expose"=true})
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
