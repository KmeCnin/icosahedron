<?php

namespace Ico\Bundle\RulesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SavingThrowsController extends Controller
{
    /**
     * @Route("/règles-pathfinder/jets-de-sauvegarde", name="ico_rules_savingthrows")
     * @Template()
     */
    public function indexAction()
    {
	   $savingthrows = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:SavingThrow')
		  ->findAll();
	   
        return $this->render('IcoRulesBundle:SavingThrows:index.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles' => 'ico_rules', 
			 'Jets de sauvegarde' => 'ico_rules_savingthrows'
		  ),
		  'title' => 'Jets de sauvegarde',
		  'subtitle' => 'Liste',
		  'list' => $savingthrows
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder/jets-de-sauvegarde/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_savingthrows_view", options={"expose"=true})
     * @Template()
     */
    public function viewAction($id)
    {
	   $savingthrow = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:SavingThrow')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:SavingThrows:view.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles' => 'ico_rules', 
			 'Jets de sauvegarde' => 'ico_rules_savingthrows',
			 $savingthrow->getName() => ''
		  ),
		  'title' => 'Jet de sauvegarde',
		  'subtitle' => $savingthrow->getName(),
		  'savingthrow' => $savingthrow
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder-aperçu/jets-de-sauvegarde/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_savingthrows_preview", options={"expose"=true})
     * @Template()
     */
    public function previewAction($id)
    {
	   $savingthrow = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:SavingThrow')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:SavingThrows:preview.html.twig', array(
		  'savingthrow' => $savingthrow
	   ));
    }
}
