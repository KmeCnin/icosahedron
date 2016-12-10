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

class ArmyController extends Controller {

    /**
     * @Route("/combats-de-masse/armées", name="ico_mass_fight")
     * @Template()
     */
    public function indexAction() {
        $armies = $this->getDoctrine()
                ->getRepository('IcoMassFightBundle:Army')
                ->findAll();

        return array(
            'breadcrumb' => array(
                'Accueil' => 'ico',
                'Combats de masse' => 'ico_massfight'
            ),
            'title' => 'Armées',
            'subtitle' => 'Combats de masse',
            'list' => $armies
        );
    }

    /**
     * @Route("/combats-de-masse/nouvelle-armée", name="ico_mass_fight_army_new")
     * @Template("IcoMassFightBundle:Army:edit.html.twig")
     */
    public function newAction(Request $request) {

        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $this->get('session')->getFlashBag()->add('warning', 'Vous devez être authentifié pour créer une nouvelle armée.');
            throw new AccessDeniedException();
        }

        $army = new Army();

        $form = $this->createForm(ArmyType::class, $army);
        $form->handleRequest($request);

        if ($form->isValid()) {
            // Si un formulaire est soumis et est valide
            $em = $this->getDoctrine()->getManager();
            $user = $this->get('security.context')->getToken()->getUser();
            $army->setCreatedBy($user);
            $em->persist($army);
            $em->flush();

            // ACL
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($army);
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

            $this->get('session')->getFlashBag()->add('success', 'L\'armée ' . $army->getName() . ' a été créée.');
            return $this->redirect($this->generateUrl('ico_mass_fight'));
        }

        return array(
            'breadcrumb' => array(
                'Accueil' => 'ico',
                'Combats de masse' => 'ico_mass_fight',
                'Nouvelle armée' => 'ico_mass_fight_army_new'
            ),
            'title' => 'Nouvelle armée',
            'subtitle' => 'Combats de masse',
            'form' => $form->createView()
        );
    }
}
