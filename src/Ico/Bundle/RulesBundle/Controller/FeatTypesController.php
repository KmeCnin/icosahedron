<?php

namespace Ico\Bundle\RulesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FeatTypesController extends Controller
{
    /**
     * @Route("/règles-pathfinder/types-de-dons", name="ico_rules_feattypes")
     * @Template()
     */
    public function indexAction()
    {
	   $feat_types = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:FeatType')
		  ->findAll();
	   
        return $this->render('IcoRulesBundle:FeatTypes:index.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles Pathfinder' => 'ico_rules', 
			 'Dons' => 'ico_rules_feats',
			 'Catégories de don' => 'ico_rules_feat_types'
		  ),
		  'title' => 'Catégories de don',
		  'subtitle' => 'Liste',
		  'list' => $feat_types
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder/types-de-dons/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_feattypes_view", options={"expose"=true})
     * @Template()
     */
    public function viewAction($id)
    {
	   $feat_type = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:FeatType')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:FeatTypes:view.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles Pathfinder' => 'ico_rules', 
			 'Dons' => 'ico_rules_feats',
			 'Catégories de don' => 'ico_rules_feattypes',
			 $feat_type->getName() => ''
		  ),
		  'title' => $feat_type->getName(),
		  'subtitle' => 'Catégorie de don',
		  'feattype' => $feat_type
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder-aperçu/types-de-dons/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_feattypes_preview", options={"expose"=true})
     * @Template()
     */
    public function previewAction($id)
    {
	   $feattype = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:FeatType')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:FeatTypes:preview.html.twig', array(
		  'feattype' => $feattype
	   ));
    }
}
