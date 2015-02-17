<?php

namespace Ico\Bundle\KingmakerBundle\Controller;

use Ico\Bundle\KingmakerBundle\Entity\Campaign;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CampaignController extends Controller
{
    /**
     * @Route("/kingmaker", name="ico_kingmaker")
     * @Template()
     */
    public function indexAction()
    {
        $campaigns = $this->getDoctrine()
		  ->getRepository('IcoKingmakerBundle:Campaign')
		  ->findAll();
        
        return array(
            'breadcrumb' => array(
                    'Accueil' => 'ico', 
                    'Kingmaker' => 'ico_kingmaker'
             ),
            'title' => 'Campagnes',
            'subtitle' => 'Kingmaker',
            'list' => $campaigns
        );
    }
    
    /**
     * @Route("/kingmaker/nouvelle-campagne", name="ico_kingmaker_campaign_new")
     * @Template("IcoKingmakerBundle:Campaign:edit.html.twig")
     */
    public function newAction(Request $request)
    {
        $campaign = new Campaign();

        $form = $this->createForm('campaign', $campaign);
	$form->handleRequest($request);

	if ($form->isValid()) {
	    // Si un formulaire est soumis et est valide
	    $em = $this->getDoctrine()->getManager();
            $user = $this->get('security.context')->getToken()->getUser();
            $campaign->setCreatedBy($user);
	    $em->persist($campaign);
	    $em->flush();
	    $this->get('session')->getFlashBag()->add('success', 'La campagne '.$campaign->getName().' a été créée.');
            return $this->redirect($this->generateUrl('ico_kingmaker'));
	}
        
        return array(
            'breadcrumb' => array(
                    'Accueil' => 'ico', 
                    'Kingmaker' => 'ico_kingmaker',
                    'Nouvelle campagne' => 'ico_kingmaker_campaign_new'
             ),
            'title' => 'Nouvelle campagne',
            'subtitle' => 'Kingmaker',
            'form' => $form->createView()
        );
    }
    
    /**
     * @Route("/kingmaker/campagnes/{id}/{slug}", name="ico_kingmaker_campaign_view", requirements={"id"="\d+"}, defaults={"slug"=false}, options={"expose"=true})
     * @Template("IcoKingmakerBundle:Campaign:view.html.twig")
     */
    public function viewAction($id)
    {
        $campaign = $this->getDoctrine()
		  ->getRepository('IcoKingmakerBundle:Campaign')
		  ->find($id);
        
        return array(
            'breadcrumb' => array(
                    'Accueil' => 'ico', 
                    'Kingmaker' => 'ico_kingmaker',
                    $campaign->getName() => ''
             ),
            'title' => $campaign->getName(),
            'subtitle' => 'Campagne',
            'campaign' => $campaign
        );
    }
}
