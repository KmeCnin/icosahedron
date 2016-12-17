<?php

namespace Ico\Bundle\MassFightBundle\Controller;

use Ico\Bundle\MassFightBundle\Entity\Army;
use Ico\Bundle\MassFightBundle\Entity\Commander;
use Ico\Bundle\MassFightBundle\Form\Type\ArmyType;
use Ico\Bundle\MassFightBundle\Form\Type\CommanderType;
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
     * @Route("/combats-de-masse/armées", name="ico_mass_fight_army")
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
                'Outils Pathfinder' => '',
                'Combats de masse' => 'ico_mass_fight_army',
                'Armées' => 'ico_mass_fight_army',
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
        $tactics = $this->getDoctrine()
			 ->getRepository('IcoMassFightBundle:Tactic')
            ->findDefaults();
        $army->setTactics($tactics);

        $form = $this->createForm(ArmyType::class, $army);
        if ($request->request->has('army') &&
            isset($request->request->get('army')['newCommander']) &&
            isset($request->request->get('army')['commander'])
        ) {
            $commander = $this->createCommander(
                $request->request->get('army')['newCommander']
            );
            $armyData = $request->request->get('army');
            $armyData['commander'] = $commander->getId();
            $request->request->set('army', $armyData);
        }
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
                'Outils Pathfinder' => '',
                'Combats de masse' => 'ico_mass_fight',
                'Armées' => 'ico_mass_fight_army',
                'Nouvelle armée' => 'ico_mass_fight_army_new'
            ),
            'title' => 'Nouvelle armée',
            'subtitle' => 'Combats de masse',
            'newCommander' => new Commander(),
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/combats-de-masse/armées/édition/{id}/{slug}", name="ico_mass_fight_army_edit")
     * @Template()
     */
    public function editAction(Request $request, $id) {

        $army = $this->getDoctrine()
                ->getRepository('IcoMassFightBundle:Army')
                ->find($id);
        if (!$army) {
            throw $this->createNotFoundException('Aucune armée trouvée pour cet id : ' . $id);
        }

        $securityContext = $this->container->get('security.context');
        if (false === $securityContext->isGranted('EDIT', $army)) {
            $this->get('session')->getFlashBag()->add('warning', 'Vous n\'avez pas le droit d\'éditer cette armée.');
            throw new AccessDeniedException();
        }

        $form = $this->createForm(ArmyType::class, $army);
        if ($request->request->has('army') &&
            isset($request->request->get('army')['newCommander']) &&
            isset($request->request->get('army')['commander'])
        ) {
            $commander = $this->createCommander(
                $request->request->get('army')['newCommander']
            );
            $armyData = $request->request->get('army');
            $armyData['commander'] = $commander->getId();
            $request->request->set('army', $armyData);
        }
        $form->handleRequest($request);

        if ($form->isValid()) {
            // Si un formulaire est soumis et est valide
            $em = $this->getDoctrine()->getManager();
            $em->persist($army);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'L\'armée ' . $army->getName() . ' a été modifiée.');
            return $this->redirect($this->generateUrl('ico_mass_fight_army_view', array('id' => $army->getId(), 'slug' => $army->getSlug())));
        }

        return array(
            'breadcrumb' => array(
                'Accueil' => 'ico',
                'Outils Pathfinder' => '',
                'Combats de masse' => 'ico_mass_fight',
                'Armées' => 'ico_mass_fight_army',
                $army->getName() => ''
            ),
            'title' => $army->getName(),
            'subtitle' => 'Édition',
            'army' => $army,
            'newCommander' => new Commander(),
            'form' => $form->createView(),
        );
    }
    
    /**
     * @param array $commanderData
     * @return Commander
     * @throws \Exception
     */
    private function createCommander(array $commanderData)
    {
        $commander = new Commander();
        $form = $this->createForm(CommanderType::class, $commander, array(
            'csrf_protection' => false,
        ));
        $form->submit($commanderData);
        
        if ($form->isValid()) {
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
            
            return $commander;
        }
        throw new \Exception($form->getErrors());
    }

    /**
     * @Route("/combats-de-masse/armées/{id}/{slug}", name="ico_mass_fight_army_view", requirements={"id"="\d+"}, defaults={"slug"=false}, options={"expose"=true})
     * @Template()
     */
    public function viewAction($id) {

        $army = $this->getDoctrine()
                ->getRepository('IcoMassFightBundle:Army')
                ->find($id);
        if (!$army) {
            throw $this->createNotFoundException('Aucune armée trouvée pour cet id : ' . $id);
        }

        return array(
            'breadcrumb' => array(
                'Accueil' => 'ico',
                'Outils Pathfinder' => '',
                'Combats de masse' => 'ico_mass_fight',
                'Armées' => 'ico_mass_fight_army',
                $army->getName() => ''
            ),
            'title' => $army->getName(),
            'subtitle' => 'Statistiques',
            'army' => $army
        );
    }

    /**
     * @Route("/combats-de-masse/armées/suppression/{id}/{slug}", name="ico_mass_fight_army_delete", requirements={"id"="\d+"}, defaults={"slug"=false})
     */
    public function deleteAction($id) {

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
