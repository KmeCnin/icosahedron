<?php

namespace Ico\Bundle\KingmakerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ico\Bundle\AppBundle\Entity\Campaign;

/**
 * KingmakerCampaign
 *
 * @ORM\Table(name="kingmaker_campaign")
 * @ORM\Entity(repositoryClass="Ico\Bundle\KingmakerBundle\Repository\KingmakerCampaignRepository")
 */
class KingmakerCampaign extends Campaign
{
    /**
     * @ORM\OneToMany(targetEntity="Map", mappedBy="campaign", cascade={"persist", "remove"})
     */
    protected $maps;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->maps = new ArrayCollection();
    }

    /**
     * Add maps
     *
     * @param Map $maps
     * @return $this
     */
    public function addMap(Map $maps)
    {
        $this->maps[] = $maps;

        return $this;
    }

    /**
     * Remove maps
     *
     * @param Map $maps
     */
    public function removeMap(Map $maps)
    {
        $this->maps->removeElement($maps);
    }

    /**
     * Get maps
     *
     * @return Collection
     */
    public function getMaps()
    {
        return $this->maps;
    }
}
