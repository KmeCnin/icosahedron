<?php

namespace Ico\Bundle\KingmakerBundle\Controller;

use Ico\Bundle\KingmakerBundle\Entity\Dot;
use Ico\Bundle\KingmakerBundle\Entity\MapInterest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MapController extends Controller {

    /**
     * @Route("/kingmaker/campagnes/{id_campaign}/{slug_campaign}/cartes/{id_map}/{slug_map}", name="ico_kingmaker_maps")
     * @Template()
     */
    public function indexAction($id_campaign, $id_map) {

        $campaign = $this->getDoctrine()
                ->getRepository('IcoKingmakerBundle:Campaign')
                ->find($id_campaign);
        $map = $this->getDoctrine()
                ->getRepository('IcoKingmakerBundle:Map')
                ->find($id_map);
        $mapInterestModels = $this->getDoctrine()
                ->getRepository('IcoKingmakerBundle:MapInterestModel')
                ->findAll();

        return array(
            'breadcrumb' => array(
                'Accueil' => 'ico',
                'Kingmaker' => 'ico_kingmaker',
                $campaign->getName() => array(
                    'route' => 'ico_kingmaker_campaign_view',
                    'params' => array(
                        'id' => $campaign->getId(),
                        'slug' => $campaign->getSlug()
                    )
                ),
                $map->getMapModel()->getName() => 'ico_kingmaker_map',
            ),
            'title' => $map->getMapModel()->getName(),
            'subtitle' => $campaign->getName(),
            'campaign' => $campaign,
            'map' => $map,
		  'mapInterestModels' => $mapInterestModels
        );
    }

    /**
     * @Route("/kingmaker/hex/explored", name="ico_kingmaker_hex_explored", options={"expose"=true})
     * @Template()
     */
    public function hexSetExploredAction(Request $request) {

        $id = $request->request->get('id');
        $explored = $request->request->get('explored');

        $hex = $this->getDoctrine()
                ->getRepository('IcoKingmakerBundle:Hex')
                ->find($id);
        if (!$hex) {
            throw $this->createNotFoundException('Aucun hexagone trouvé pour cet id : ' . $id);
        }

        $securityContext = $this->container->get('security.context');
        if (false === $securityContext->isGranted('EDIT', $hex->getMap()->getCampaign())) {
            $this->get('session')->getFlashBag()->add('warning', 'Vous n\'avez pas le droit d\'éditer cette campagne.');
            throw new AccessDeniedException();
        }

        try {

            $em = $this->getDoctrine()->getManager();

            $hex->setExplored($explored);
            if (!$explored) {
                $hex->setAnnexed(false);
            }
            $em->persist($hex);
            $em->flush();

            return new Response('Mise à jour réussie.');
        } catch (Exception $e) {
            echo 'Exception reçue : ', $e->getMessage(), "\n";
        }
    }

    /**
     * @Route("/kingmaker/hex/annexed", name="ico_kingmaker_hex_annexed", options={"expose"=true})
     * @Template()
     */
    public function hexSetAnnexedAction(Request $request) {

        $id = $request->request->get('id');
        $annexed = $request->request->get('annexed');

        $hex = $this->getDoctrine()
                ->getRepository('IcoKingmakerBundle:Hex')
                ->find($id);
        if (!$hex) {
            throw $this->createNotFoundException('Aucun hexagone trouvé pour cet id : ' . $id);
        }

        $securityContext = $this->container->get('security.context');
        if (false === $securityContext->isGranted('EDIT', $hex->getMap()->getCampaign())) {
            $this->get('session')->getFlashBag()->add('warning', 'Vous n\'avez pas le droit d\'éditer cette campagne.');
            throw new AccessDeniedException();
        }

        try {

            $em = $this->getDoctrine()->getManager();

            $hex->setAnnexed($annexed);
            if ($annexed) {
                $hex->setExplored(true);
            }
            $em->persist($hex);
            $em->flush();

            return new Response('Mise à jour réussie.');
        } catch (Exception $e) {
            echo 'Exception reçue : ', $e->getMessage(), "\n";
        }
    }

    /**
     * @Route("/kingmaker/map/frontier", name="ico_kingmaker_map_frontier", options={"expose"=true})
     * @Template()
     */
    public function frontierAction(Request $request) {

        $id = $request->request->get('id');

        $hex = $this->getDoctrine()
                ->getRepository('IcoKingmakerBundle:Hex')
                ->find($id);
        if (!$hex) {
            throw $this->createNotFoundException('Aucun hexagone trouvé pour cet id : ' . $id);
        }
        
        return array('map' => $hex->getMap());
    }

}
