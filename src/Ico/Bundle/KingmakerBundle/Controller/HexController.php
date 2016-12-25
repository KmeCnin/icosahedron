<?php

namespace Ico\Bundle\KingmakerBundle\Controller;

use Ico\Bundle\KingmakerBundle\Entity\Dot;
use Ico\Bundle\KingmakerBundle\Entity\MapInterest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class HexController extends Controller {

    /**
     * @Route("/kingmaker/map/interests", name="ico_kingmaker_map_interests", options={"expose"=true})
     * @Template("IcoKingmakerBundle:Map:interests.html.twig")
     */
    public function interestsAction(Request $request) {

        $id = $request->request->get('id');
        $hex = $this->getDoctrine()
                ->getRepository('IcoKingmakerBundle:Hex')
                ->find($id);
        if (!$hex) {
            throw $this->createNotFoundException('Aucun hexagone trouvé pour cet id : ' . $id);
        }

        return array('map' => $hex->getMap());
    }
    
    /**
     * @Route("/kingmaker/map/interests_list", name="ico_kingmaker_map_interests_list", options={"expose"=true})
     * @Template("IcoKingmakerBundle:Map:interestsList.html.twig")
     */
    public function interestsListAction(Request $request) {

        $id = $request->request->get('id');
        $hex = $this->getDoctrine()
                ->getRepository('IcoKingmakerBundle:Hex')
                ->find($id);
        if (!$hex) {
            throw $this->createNotFoundException('Aucun hexagone trouvé pour cet id : ' . $id);
        }
            
        $mapInterests = $this->getDoctrine()
            ->getRepository('IcoKingmakerBundle:MapInterest')
            ->findByHex($hex);

        return array('list' => $mapInterests);
    }
    
    /**
     * @Route("/kingmaker/map/interests_list_modals", name="ico_kingmaker_map_interests_list_modals", options={"expose"=true})
     * @Template("IcoKingmakerBundle:Map:interestsListModals.html.twig")
     */
    public function interestsListModalsAction(Request $request) {

        $id = $request->request->get('id');
        $hex = $this->getDoctrine()
                ->getRepository('IcoKingmakerBundle:Hex')
                ->find($id);
        if (!$hex) {
            throw $this->createNotFoundException('Aucun hexagone trouvé pour cet id : ' . $id);
        }
            
        $mapInterests = $this->getDoctrine()
            ->getRepository('IcoKingmakerBundle:MapInterest')
            ->findByHex($hex);

        return array('list' => $mapInterests);
    }

    /**
     * @Route("/kingmaker/interest/add", name="ico_kingmaker_interest_add", options={"expose"=true})
     * @Template("IcoKingmakerBundle:Map:interestsList.html.twig")
     */
    public function mapInterestAddAction(Request $request) {

        $id_hex = $request->request->get('id_hex');
        $id_interestmodel = $request->request->get('id_interestmodel');

        $hex = $this->getDoctrine()
                ->getRepository('IcoKingmakerBundle:Hex')
                ->find($id_hex);
        if (!$hex) {
            throw $this->createNotFoundException('Aucun hexagone trouvé pour cet id : ' . $id_hex);
        }
        $mapInterestModel = $this->getDoctrine()
                ->getRepository('IcoKingmakerBundle:MapInterestModel')
                ->find($id_interestmodel);
        if (!$mapInterestModel) {
            throw $this->createNotFoundException('Aucun modèle de point d\'intérêt trouvé pour cet id : ' . $id_interestmodel);
        }

        $securityContext = $this->container->get('security.context');
        if (false === $securityContext->isGranted('EDIT', $hex->getMap()->getCampaign())) {
            $this->get('session')->getFlashBag()->add('warning', 'Vous n\'avez pas le droit d\'éditer cette campagne.');
            throw new AccessDeniedException();
        }

        try {

            $em = $this->getDoctrine()->getManager();

            $mapInterest = new MapInterest();
            $mapInterest->setMapInterestModel($mapInterestModel);
            $mapInterest->setHex($hex);
            $mapInterest->setName($mapInterestModel->getName());
            
            $mapInterest->setPosition(new Dot($hex->getCenterX(), $hex->getCenterY()));
            
            $em->persist($mapInterest);
            
            $hex->addMapInterest($mapInterest);
            $em->persist($hex);
            
            $em->flush();
            
            $mapInterests = $this->getDoctrine()
                ->getRepository('IcoKingmakerBundle:MapInterest')
                ->findByHex($hex);

            return array('list' => $mapInterests);
        } catch (Exception $e) {
            echo 'Exception reçue : ', $e->getMessage(), "\n";
        }
    }

    /**
     * @Route("/kingmaker/interest/delete", name="ico_kingmaker_interest_delete", options={"expose"=true})
     * @Template("IcoKingmakerBundle:Map:interestsList.html.twig")
     */
    public function mapInterestDeleteAction(Request $request) {

        $id = $request->request->get('id');

        $interest = $this->getDoctrine()
                ->getRepository('IcoKingmakerBundle:MapInterest')
                ->find($id);
        if (!$interest) {
            throw $this->createNotFoundException('Aucun point d\'intérêt trouvé pour cet id : ' . $id);
        }

        $securityContext = $this->container->get('security.context');
        if (false === $securityContext->isGranted('EDIT', $interest->getHex()->getMap()->getCampaign())) {
            $this->get('session')->getFlashBag()->add('warning', 'Vous n\'avez pas le droit d\'éditer cette campagne.');
            throw new AccessDeniedException();
        }

        try {

            $em = $this->getDoctrine()->getManager();
            $em->remove($interest);              
            $em->flush();
            
            $mapInterests = $this->getDoctrine()
                ->getRepository('IcoKingmakerBundle:MapInterest')
                ->findByHex($interest->getHex());

            return array('list' => $mapInterests);
        } catch (Exception $e) {
            echo 'Exception reçue : ', $e->getMessage(), "\n";
        }
    }

    /**
     * @Route("/kingmaker/interest/edit", name="ico_kingmaker_interest_edit", options={"expose"=true})
     * @Template("IcoKingmakerBundle:Map:interests.html.twig")
     */
    public function mapInterestEditAction(Request $request) {

        $id = $request->request->get('id');

        $interest = $this->getDoctrine()
                ->getRepository('IcoKingmakerBundle:MapInterest')
                ->find($id);
        if (!$interest) {
            throw $this->createNotFoundException('Aucun point d\'intérêt trouvé pour cet id : ' . $id);
        }

        $securityContext = $this->container->get('security.context');
        if (false === $securityContext->isGranted('EDIT', $interest->getHex()->getMap()->getCampaign())) {
            $this->get('session')->getFlashBag()->add('warning', 'Vous n\'avez pas le droit d\'éditer cette campagne.');
            throw new AccessDeniedException();
        }

        try {
            
            $name = $request->request->get('name');
            $description = $request->request->get('description');
            $position = new Dot($request->request->get('positionX'), $request->request->get('positionY'));
            
            $em = $this->getDoctrine()->getManager();
            $interest->setName($name);
            $interest->setDescription($description);
            $interest->setPosition($position);
            $em->persist($interest);              
            $em->flush();

            return array('map' => $interest->getHex()->getMap());
        } catch (Exception $e) {
            echo 'Exception reçue : ', $e->getMessage(), "\n";
        }
    }
}
