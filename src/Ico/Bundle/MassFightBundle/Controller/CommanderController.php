<?php

namespace Ico\Bundle\MassFightBundle\Controller;

use Ico\Bundle\MassFightBundle\Entity\Army;
use Ico\Bundle\MassFightBundle\Form\Type\ArmyType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CommanderController extends Controller {

    /**
     * @Route("/combats-de-masse/commandants", name="ico_mass_fight_commander")
     * @Template()
     */
    public function indexAction() {
        $commanders = $this->getDoctrine()
                ->getRepository('IcoMassFightBundle:Commander')
                ->findAll();

        return array(
            'breadcrumb' => array(
                'Accueil' => 'ico',
                'Combats de masse' => 'ico_mass_fight_army',
                'Commandants' => 'ico_mass_fight_commander',
            ),
            'title' => 'Commandants',
            'subtitle' => 'Combats de masse',
            'list' => $commanders
        );
    }

    /**
     * @Route("/combats-de-masse/nouveau-commandant", name="ico_mass_fight_commander_new")
     * @Template("IcoMassFightBundle:Commander:edit.html.twig")
     */
    public function newAction(Request $request) {

        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $this->get('session')->getFlashBag()->add('warning', 'Vous devez être authentifié pour créer un nouveau commandant.');
            throw new AccessDeniedException();
        }

        $commander = new Commander();

        $form = $this->createForm(CommanderType::class, $commander);
        $form->handleRequest($request);

        if ($form->isValid()) {
            // Si un formulaire est soumis et est valide
            $em = $this->getDoctrine()->getManager();
            $user = $this->get('security.context')->getToken()->getUser();
            $commander->setCreatedBy($user);
            $em->persist($commander);
            $em->flush();

            // ACL
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($commander);
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

            $this->get('session')->getFlashBag()->add('success', 'Le commandant ' . $commander->getName() . ' a été créé.');
            return $this->redirect($this->generateUrl('ico_mass_fight'));
        }

        return array(
            'breadcrumb' => array(
                'Accueil' => 'ico',
                'Combats de masse' => 'ico_mass_fight',
                'Nouveau commandant' => 'ico_mass_fight_commander_new'
            ),
            'title' => 'Nouveau commandant',
            'subtitle' => 'Combats de masse',
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/combats-de-masse/commandants/édition/{id}/{slug}", name="ico_mass_fight_commander_edit")
     * @Template()
     */
    public function editAction(Request $request, $id) {

        $commander = $this->getDoctrine()
                ->getRepository('IcoMassFightBundle:Commander')
                ->find($id);
        if (!$commander) {
            throw $this->createNotFoundException('Aucun commandant trouvé pour cet id : ' . $id);
        }

        $securityContext = $this->container->get('security.context');
        if (false === $securityContext->isGranted('EDIT', $commander)) {
            $this->get('session')->getFlashBag()->add('warning', 'Vous n\'avez pas le droit d\'éditer ce commandant.');
            throw new AccessDeniedException();
        }

        $form = $this->createForm(CommanderType::class, $commander);
        $form->handleRequest($request);

        if ($form->isValid()) {
            // Si un formulaire est soumis et est valide
            $em = $this->getDoctrine()->getManager();
            $em->persist($commander);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Le commandant ' . $commander->getName() . ' a été modifié.');
            return $this->redirect($this->generateUrl('ico_mass_fight_commander_view', array('id' => $commander->getId(), 'slug' => $commander->getSlug())));
        }

        return array(
            'breadcrumb' => array(
                'Accueil' => 'ico',
                'Combats de masse' => 'ico_mass_fight',
                $commander->getName() => ''
            ),
            'title' => $commander->getName(),
            'subtitle' => 'Édition',
            'commander' => $commander,
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/combats-de-masse/commandants/{id}/{slug}", name="ico_mass_fight_commander_view", requirements={"id"="\d+"}, defaults={"slug"=false}, options={"expose"=true})
     * @Template()
     */
    public function viewAction($id) {

        $army = $this->getDoctrine()
                ->getRepository('IcoMassFightBundle:Commander')
                ->find($id);
        if (!$army) {
            throw $this->createNotFoundException('Aucun commandant trouvé pour cet id : ' . $id);
        }

        return array(
            'breadcrumb' => array(
                'Accueil' => 'ico',
                'Combats de masse' => 'ico_mass_fight',
                $army->getName() => ''
            ),
            'title' => $army->getName(),
            'subtitle' => 'Aperçu',
            'army' => $army
        );
    }

    /**
     * @Route("/combats-de-masse/armées/suppression/{id}/{slug}", name="ico_mass_fight_army_delete", requirements={"id"="\d+"}, defaults={"slug"=false})
     */
    public function deleteGuestAction($id) {

        $army = $this->getDoctrine()
                ->getRepository('IcoMassFightBundle:Army')
                ->find($id);
        if (!$army) {
            throw $this->createNotFoundException('Aucune armée trouvée pour cet id : ' . $id);
        }
        
        $securityContext = $this->container->get('security.context');
        if (false === $securityContext->isGranted('DELETE', $army)) {
            $this->get('session')->getFlashBag()->add('warning', 'Vous n\'avez pas le droit de supprimer cette armée.');
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($army);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('success', 'L\'armée ' . $army->getName() . ' a été supprimée.');
        return $this->redirect($this->generateUrl('ico_mass_fight'));
    }
}
