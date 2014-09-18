<?php

namespace Ico\Bundle\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RulesController extends Controller
{
    /**
     * @Route("/", name="ico_rules")
     * @Template()
     */
    public function indexAction()
    {
        return $this->render('IcoAppBundle::rules.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico',
			 'Règles' => 'ico_rules'
		  ),
		  'title' => 'Accueil',
		  'subtitle' => 'Bienvenue'
	   ));
    }
}
