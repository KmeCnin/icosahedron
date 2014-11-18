<?php

namespace Ico\Bundle\RulesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SavingThrowEffectsController extends Controller
{
    /**
     * @Route("/règles-pathfinder/effets-de-sauvegarde", name="ico_rules_savingthroweffects")
     * @Template()
     */
    public function indexAction()
    {
	   $savingthroweffects = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:SavingThrowEffect')
		  ->findAll();
	   
        return $this->render('IcoRulesBundle:SavingThrowEffects:index.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles' => 'ico_rules', 
			 'Jets de sauvegarde' => 'ico_rules_savingthrows',
			 'Effets de sauvegarde' => 'ico_rules_savingthroweffects'
		  ),
		  'title' => 'Effets de sauvegarde',
		  'subtitle' => 'Liste',
		  'list' => $savingthroweffects
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder/effets-de-sauvegarde/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_savingthroweffects_view", options={"expose"=true})
     * @Template()
     */
    public function viewAction($id)
    {
	   $savingthroweffect = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:SavingThrowEffect')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:SavingThrowEffects:view.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles' => 'ico_rules', 
			 'Jets de sauvegarde' => 'ico_rules_savingthrows',
			 'Effets de sauvegarde' => 'ico_rules_savingthroweffects',
			 $savingthroweffect->getName() => ''
		  ),
		  'title' => 'Effet de sauvegarde',
		  'subtitle' => $savingthroweffect->getName(),
		  'savingthroweffect' => $savingthroweffect
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder-aperçu/effets-de-sauvegarde/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_savingthroweffects_preview", options={"expose"=true})
     * @Template()
     */
    public function previewAction($id)
    {
	   $savingthroweffect = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:SavingThrowEffect')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:SavingThrowEffects:preview.html.twig', array(
		  'savingthroweffect' => $savingthroweffect
	   ));
    }
}
