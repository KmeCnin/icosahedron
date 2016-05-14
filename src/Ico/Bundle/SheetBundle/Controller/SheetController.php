<?php

namespace Ico\Bundle\SheetBundle\Controller;

use Ico\Bundle\SheetBundle\Entity\Sheet;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class SheetController extends Controller
{
    /**
     * @Route("/fiches-de-personnage", name="ico_sheet")
     * @Template()
     */
    public function indexAction()
    {
        $sheets = $this->getDoctrine()
            ->getRepository('IcoSheetBundle:Sheet')
            ->findAll();

        return array(
            'breadcrumb' => array(
                'Accueil' => 'ico',
                'Fiches de personnage' => 'ico_sheet'
            ),
            'title' => 'Fiches de personnage',
            'subtitle' => 'Liste',
            'list' => $sheets
        );
    }
    
    /**
     * @Route("/fiches-de-personnage/création", name="ico_sheet_new")
     * @Template("IcoSheetBundle:Sheet:edit.html.twig")
     */
    public function newAction(Request $request) {

        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $this->get('session')->getFlashBag()->add('warning', 'Vous devez être authentifié pour créer une nouvelle fiche de personnage.');
            throw new AccessDeniedException();
        }

        $sheet = new Sheet();

        $form = $this->createForm('sheet', $sheet);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->get('security.context')->getToken()->getUser();
            $sheet->setCreatedBy($user);
            $em->persist($sheet);
            $em->flush();

            // ACL
            $aclProvider = $this->get('security.acl.provider');
            $objectIdentity = ObjectIdentity::fromDomainObject($sheet);
            $acl = $aclProvider->createAcl($objectIdentity);
            $securityIdentity = UserSecurityIdentity::fromAccount($user);
            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $aclProvider->updateAcl($acl);

            $this->get('session')->getFlashBag()->add('success', 'La fiche de personnage ' . $sheet->getCharacterName() . ' a été créée.');
            return $this->redirect($this->generateUrl('ico_sheet'));
        }

        return array(
            'breadcrumb' => array(
                'Accueil' => 'ico',
                'Fiches de personnage' => 'ico_sheet',
                'Création' => 'ico_sheet_new'
            ),
            'title' => 'Fiche de personnage',
            'subtitle' => 'Création',
            'form' => $form->createView()
        );
    }
    
    /**
     * @Route("/fiches-de-personnage/édition/{id}/{slug}", name="ico_sheet_edit")
     * @Template()
     */
    public function editAction(Request $request, $id) {

        $sheet = $this->getDoctrine()
                ->getRepository('IcoSheetBundle:Sheet')
                ->find($id);
        if (!$sheet) {
            throw $this->createNotFoundException('Aucune fiche de personnage trouvée pour cet id : ' . $id);
        }

        $securityContext = $this->container->get('security.context');
        if (false === $securityContext->isGranted('EDIT', $sheet)) {
            $this->get('session')->getFlashBag()->add('warning', 'Vous n\'avez pas le droit d\'éditer cette fiche de personnage.');
            throw new AccessDeniedException();
        }

        $form = $this->createForm('sheet', $sheet);
        $form->handleRequest($request);

        if ($form->isValid()) {
            // Si un formulaire est soumis et est valide
            $em = $this->getDoctrine()->getManager();
            $em->persist($sheet);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'La fiche de personnage ' . $sheet->getCharacterName() . ' a été modifiée.');
        }

        return array(
            'breadcrumb' => array(
                'Accueil' => 'ico',
                'Fiches de personnage' => 'ico_sheet',
                $sheet->getCharacterName() => ''
            ),
            'title' => $sheet->getCharacterName(),
            'subtitle' => 'Édition',
            'sheet' => $sheet,
            'form' => $form->createView()
        );
    }
    
    /**
     * @Route("/fiches-de-personnage/{id}/{slug}", name="ico_sheet_view", requirements={"id"="\d+"}, defaults={"slug"=false}, options={"expose"=true})
     * @Template()
     */
    public function viewAction($id) {

        $sheet = $this->getDoctrine()
                ->getRepository('IcoSheetBundle:Sheet')
                ->find($id);
        if (!$sheet) {
            throw $this->createNotFoundException('Aucune fiche de personnage trouvée pour cet id : ' . $id);
        }

        return array(
            'breadcrumb' => array(
                'Accueil' => 'ico',
                'Fiches de personnages' => 'ico_sheet',
                $sheet->getCharacterName() => ''
            ),
            'title' => $sheet->getCharacterName(),
            'subtitle' => 'Fiche de personnage',
            'sheet' => $sheet
        );
    }

    /**
     * @Route("/fiches-de-personnage/suppression/{id}/{slug}", name="ico_sheet_delete", requirements={"id"="\d+"}, defaults={"slug"=false})
     */
    public function deleteAction($id) {

        $sheet = $this->getDoctrine()
                ->getRepository('IcoSheetBundle:Sheet')
                ->find($id);
        if (!$sheet) {
            throw $this->createNotFoundException('Aucune fiche de personnage trouvée pour cet id : ' . $id);
        }
        
        $securityContext = $this->container->get('security.context');
        if (false === $securityContext->isGranted('DELETE', $sheet)) {
            $this->get('session')->getFlashBag()->add('warning', 'Vous n\'avez pas le droit de supprimer cette fiche de personnage.');
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($sheet);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('success', 'La fiche de personnage ' . $sheet->getCharacterName() . ' a été supprimée.');
        return $this->redirect($this->generateUrl('ico_sheet'));
    }
}
