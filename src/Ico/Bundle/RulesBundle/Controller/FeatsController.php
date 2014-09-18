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
	   $feats = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:Feat')
		  ->findAll();
	   
        return $this->render('IcoRulesBundle:Feats:index.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles' => 'ico_rules', 
			 'Dons' => 'ico_rules_feats'
		  ),
		  'title' => 'Dons',
		  'subtitle' => 'Liste',
		  'list' => $feats
	   ));
    }
}
