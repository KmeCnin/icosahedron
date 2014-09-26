<?php

namespace Ico\Bundle\RulesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FeatTypesController extends Controller
{
    /**
     * @Route("/rules/feattypes", name="ico_rules_feattypes")
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
			 'Règles' => 'ico_rules', 
			 'Dons' => 'ico_rules_feats',
			 'Catégories de don' => 'ico_rules_feat_types'
		  ),
		  'title' => 'Catégories de don',
		  'subtitle' => 'Liste',
		  'list' => $feat_types
	   ));
    }
    
    /**
     * @Route("/rules/feattypes/view/{id}", name="ico_rules_feattypes_view", options={"expose"=true})
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
			 'Règles' => 'ico_rules', 
			 'Dons' => 'ico_rules_feats',
			 'Catégories de don' => 'ico_rules_feattypes',
			 $feat_type->getName() => ''
		  ),
		  'title' => 'Catégorie de don',
		  'subtitle' => $feat_type->getName(),
		  'feattype' => $feat_type
	   ));
    }
    
    /**
     * @Route("/rules/feattypes/preview/{id}", name="ico_rules_feattypes_preview", options={"expose"=true})
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
