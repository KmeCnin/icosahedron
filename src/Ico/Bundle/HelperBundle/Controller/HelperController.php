<?php

namespace Ico\Bundle\HelperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HelperController extends Controller
{
    /**
     * @Route("/helper")
     * @Template()
     */
    public function indexAction()
    {
        return $this->render('IcoHelperBundle:Helper:index.html.twig');
    }
}
