<?php

namespace Ico\Bundle\RulesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class SkillsController extends Controller
{
    /**
     * @Route("/règles-pathfinder/compétences", name="ico_rules_skills")
     * @Template()
     */
    public function indexAction(Request $request)
    {	   	   	   
	   $skills = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:Skill')
		  ->findAll();
	   
        return $this->render('IcoRulesBundle:Skills:index.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles Pathfinder' => 'ico_rules', 
			 'Compétences' => 'ico_rules_skills'
		  ),
		  'title' => 'Compétences',
		  'subtitle' => 'Liste',
		  'list' => $skills
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder/compétences/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_skills_view", options={"expose"=true})
     * @Template()
     */
    public function viewAction($id)
    {
	   $skill = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:Skill')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:Skills:view.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles Pathfinder' => 'ico_rules', 
			 'Compétences' => 'ico_rules_skills',
			 $skill->getName() => ''
		  ),
		  'title' => ucfirst($skill->getName()),
		  'subtitle' => 'Compétences',
		  'skill' => $skill
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder-aperçu/compétences/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_skills_preview", options={"expose"=true})
     * @Template()
     */
    public function previewAction($id)
    {
	   $skill = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:Skill')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:Skills:preview.html.twig', array(
		  'skill' => $skill
	   ));
    }
}
