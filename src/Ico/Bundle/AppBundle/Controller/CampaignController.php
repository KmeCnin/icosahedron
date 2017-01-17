<?php

namespace Ico\Bundle\AppBundle\Controller;

use Ico\Bundle\AppBundle\Entity\Campaign;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class CampaignController extends Controller
{
    /**
     * @Route("/campagnes", name="ico_campaigns")
     * @Template()
     */
    public function indexAction()
    {
        if (!$this->getUser()) {
            $this->get('session')->getFlashBag()->add('warning', 'Vous devez être authentifié pour accéder aux campagnes.');
            throw new AccessDeniedException();
        }

        $campaigns = $this->getDoctrine()
            ->getRepository('IcoAppBundle:Campaign')
            ->findAllAs($this->getUser());

        return [
            'breadcrumb' => array(
                'Accueil' => 'ico',
            ),
            'title' => 'Campagnes',
            'subtitle' => 'Profile',
            'list' => $campaigns
        ];
    }

    /**
     * @Route("/nouvelle-campagne", name="ico_campaign_new")
     * @Template("IcoAppBundle:Campaign:edit.html.twig")
     */
    public function newAction(Request $request)
    {
        if (!$this->getUser()) {
            $this->get('session')->getFlashBag()->add('warning', 'Vous devez être authentifié pour accéder aux campagnes.');
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
            $admins = $this->getDoctrine()
                ->getRepository('IcoUserBundle:User')
                ->findByRole('ROLE_ADMIN');
            // Accès pour les admins
            foreach ($admins as $admin) {
                $securityIdentity = UserSecurityIdentity::fromAccount($admin);
                $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            }
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
     * @Route("/campagnes/paramètres/{id}/{slug}", name="ico_campaign_edit")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {

        $campaign = $this->getDoctrine()
            ->getRepository('IcoAppBundle:Campaign')
            ->findOneAs($id, $this->getUser());

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
            'campaign' => $campaign,
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/campagnes/suppression/{id}/{slug}", name="ico_campaign_delete", requirements={"id"="\d+"}, defaults={"slug"=false})
     */
    public function deleteAction($id) {

        $campaign = $this->getDoctrine()
            ->getRepository('IcoAppBundle:Campaign')
            ->find($id);
        if (!$campaign) {
            throw $this->createNotFoundException('Aucune campagne trouvée pour cet id : ' . $id);
        }

        $securityContext = $this->container->get('security.context');
        if (false === $securityContext->isGranted('DELETE', $campaign)) {
            $this->get('session')->getFlashBag()->add('warning', 'Vous n\'avez pas le droit de supprimer cette campagne.');
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($campaign);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'La campagne ' . $campaign->getName() . ' a été supprimée.');
        return $this->redirect($this->generateUrl('ico_campaigns'));
    }
}
