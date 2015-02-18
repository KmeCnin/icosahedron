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

class MapController extends Controller {

    /**
     * @Route("/kingmaker/campaign/{id_campaign}/{slug_campaign}/maps/{id_mapmodel}/{slug_mapmodel}", name="ico_kingmaker_maps")
     * @Template()
     */
    public function indexAction($id_campaign, $id_mapmodel) {
        
        $campaign = $this->getDoctrine()
                ->getRepository('IcoKingmakerBundle:Campaign')
                ->find($id_campaign);
        $mapModel = $this->getDoctrine()
                ->getRepository('IcoKingmakerBundle:MapModel')
                ->find($id_mapmodel);

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
                $mapModel->getName() => 'ico_kingmaker_map',
            ),
            'title' => $mapModel->getName(),
            'subtitle' => $campaign->getName(),
            'campaign' => $campaign,
            'mapModel' => $mapModel
        );
    }

}
