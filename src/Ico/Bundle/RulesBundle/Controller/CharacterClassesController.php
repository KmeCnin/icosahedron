<?php

namespace Ico\Bundle\RulesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class CharacterClassesController extends Controller
{
    /**
     * @Route("/règles-pathfinder/classes", name="ico_rules_characterclasses")
     * @Template()
     */
    public function indexAction(Request $request)
    {	   	   	   
	   $classes = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:CharacterClass')
		  ->findAll();
	   
        return $this->render('IcoRulesBundle:CharacterClasses:index.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles Pathfinder' => 'ico_rules', 
			 'Classes' => 'ico_rules_characterclasses'
		  ),
		  'title' => 'Classes',
		  'subtitle' => 'Liste',
		  'list' => $classes
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder/classes/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_characterclasses_view", options={"expose"=true})
     * @Template()
     */
    public function viewAction($id)
    {
	   $class = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:CharacterClass')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:CharacterClasses:view.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles Pathfinder' => 'ico_rules', 
			 'Classes' => 'ico_rules_characterclasses',
			 $class->getName() => ''
		  ),
		  'title' => ucfirst($class->getName()),
		  'subtitle' => 'Classe',
		  'class' => $class
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder-aperçu/classes/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_characterclasses_preview", options={"expose"=true})
     * @Template()
     */
    public function previewAction($id)
    {
	   $class = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:CharacterClass')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:CharacterClasses:preview.html.twig', array(
		  'class' => $class
	   ));
    }
}
