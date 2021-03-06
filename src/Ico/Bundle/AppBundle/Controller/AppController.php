<?php

namespace Ico\Bundle\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AppController extends Controller
{
    /**
     * @Route("/", name="ico")
     * @Template()
     */
    public function indexAction()
    {
        return $this->render('IcoAppBundle::index.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico'
		  ),
		  'title' => 'Accueil',
		  'subtitle' => 'Bienvenue'
	   ));
    }
}
