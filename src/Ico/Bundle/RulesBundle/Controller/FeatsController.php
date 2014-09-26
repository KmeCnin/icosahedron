<?php

namespace Ico\Bundle\RulesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FeatsController extends Controller
{
    /**
     * @Route("/rules/feats", name="ico_rules_feats")
     * @Template()
     */
    public function indexAction()
    {	   
	   $em = $this->get('doctrine.orm.entity_manager');
	   $dql = "SELECT feat FROM IcoRulesBundle:Feat feat";
	   $query = $em->createQuery($dql);
	   $pagination = $this->get('knp_paginator')->paginate(
		   $query, $this->get('request')->query->get('page', 1) /* page number */, 50 /* limit per page */
	   );
	   
	   $feattypes = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:FeatType')
		  ->findAll();
	   
	   $featprerequisites = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:FeatPrerequisite')
		  ->findAll();
	   
        return $this->render('IcoRulesBundle:Feats:index.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles' => 'ico_rules', 
			 'Dons' => 'ico_rules_feats'
		  ),
		  'title' => 'Dons',
		  'subtitle' => 'Liste',
		  'feattypes' => $feattypes,
		  'featprerequisites' => $featprerequisites,
		  'pagination' => $pagination
	   ));
    }
    
    /**
     * @Route("/rules/feat/view/{id}", name="ico_rules_feat_view", options={"expose"=true})
     * @Template()
     */
    public function viewAction($id)
    {
	   $feat = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:Feat')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:Feats:view.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles' => 'ico_rules', 
			 'Dons' => 'ico_rules_feats',
			 $feat->getName() => ''
		  ),
		  'title' => 'Don',
		  'subtitle' => $feat->getName(),
		  'feat' => $feat
	   ));
    }
    
    /**
     * @Route("/rules/feat/preview/{id}", name="ico_rules_feat_preview", options={"expose"=true})
     * @Template()
     */
    public function previewAction($id)
    {
	   $feat = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:Feat')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:Feats:preview.html.twig', array(
		  'feat' => $feat
	   ));
    }
}
