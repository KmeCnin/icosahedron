<?php

namespace Ico\Bundle\KingmakerBundle\Controller;

use Ico\Bundle\KingmakerBundle\Entity\Campaign;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CampaignController extends Controller {

    /**
     * @Route("/kingmaker", name="ico_kingmaker")
     * @Template()
     */
    public function indexAction() {
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
    public function newAction(Request $request) {

        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $this->get('session')->getFlashBag()->add('warning', 'Vous devez être authentifié pour créer une nouvelle campagne.');
            throw new AccessDeniedException();
        }

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

            // ACL
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($campaign);
            $acl = $aclProvider->createAcl($objectIdentity);
            $securityIdentity = UserSecurityIdentity::fromAccount($user);
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);

            $this->get('session')->getFlashBag()->add('success', 'La campagne ' . $campaign->getName() . ' a été créée.');
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
     * @Route("/kingmaker/campagnes/paramètres/{id}/{slug}", name="ico_kingmaker_campaign_edit")
     * @Template("IcoKingmakerBundle:Campaign:edit.html.twig")
     */
    public function editAction(Request $request, $id) {

        $campaign = $this->getDoctrine()
		->getRepository('IcoKingmakerBundle:Campaign')
		->find($id);
	if (!$campaign) {
	    throw $this->createNotFoundException('Aucune campagne trouvée pour cet id : ' . $id);
	}
        
        $securityContext = $this->container->get('security.context');
        if (false === $securityContext->isGranted('EDIT', $campaign)) {
            $this->get('session')->getFlashBag()->add('warning', 'Vous n\'avez pas le droit d\'éditer cette campagne.');
            throw new AccessDeniedException();
        }

        $form = $this->createForm('campaign', $campaign);
        $form->handleRequest($request);

        if ($form->isValid()) {
            // Si un formulaire est soumis et est valide
            $em = $this->getDoctrine()->getManager();
            $em->persist($campaign);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'La campagne ' . $campaign->getName() . ' a été modifiée.');
            return $this->redirect($this->generateUrl('ico_kingmaker_campaign_view', array('id' => $campaign->getId(), 'slug' => $campaign->getSlug())));
        }

        return array(
            'breadcrumb' => array(
                'Accueil' => 'ico',
                'Kingmaker' => 'ico_kingmaker',
                $campaign->getName() => ''
            ),
            'title' => $campaign->getName(),
            'subtitle' => 'Paramètres',
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/kingmaker/campagnes/{id}/{slug}", name="ico_kingmaker_campaign_view", requirements={"id"="\d+"}, defaults={"slug"=false}, options={"expose"=true})
     * @Template("IcoKingmakerBundle:Campaign:view.html.twig")
     */
    public function viewAction($id) {
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
