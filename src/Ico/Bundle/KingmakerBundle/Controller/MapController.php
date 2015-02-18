<?php

namespace Ico\Bundle\KingmakerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
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
            'map' => $map
        );
    }
    
    /**
     * @Route("/kingmaker/hex/explored", name="ico_kingmaker_hex_explored", options={"expose"=true})
     * @Template()
     */
    public function hexSetExploredAction(Request $request) {
        try {
		  $id = $request->request->get('id');
		  $explored = $request->request->get('explored');

		  $hex = $this->getDoctrine()
				->getRepository('IcoKingmakerBundle:Hex')
				->find($id);
		  if (!$hex) {
			 throw $this->createNotFoundException('Aucun hexagone trouvé pour cet id : ' . $id);
		  }

		  $em = $this->getDoctrine()->getManager();

		  $hex->setExplored($explored);
		  $em->persist($hex);
		  $em->flush();

		  return new Response('Mise à jour réussie.');
	   } catch (Exception $e) {
		  echo 'Exception reçue : ',  $e->getMessage(), "\n";
	   }
    }

}
