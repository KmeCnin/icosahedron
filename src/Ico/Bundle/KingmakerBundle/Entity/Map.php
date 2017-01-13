<?php

namespace Ico\Bundle\KingmakerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations

/**
 * Map
 *
 * @ORM\Table(name="kingmaker_map")
 * @ORM\Entity(repositoryClass="Ico\Bundle\KingmakerBundle\Repository\MapRepository")
 */
class Map
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="MapModel", inversedBy="maps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mapModel;
    
    /**
     * @ORM\ManyToOne(targetEntity="KingmakerCampaign", inversedBy="maps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campaign;
    
    /**
     * @ORM\OneToMany(targetEntity="Hex", mappedBy="map", cascade={"persist", "remove"})
     */
    protected $hexs;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->hexs = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mapModel
     *
     * @param MapModel $mapModel
     * @return Map
     */
    public function setMapModel(MapModel $mapModel)
    {
        $this->mapModel = $mapModel;

        return $this;
    }

    /**
     * Get mapModel
     *
     * @return MapModel
     */
    public function getMapModel()
    {
        return $this->mapModel;
    }

    /**
     * Add hexs
     *
     * @param Hex $hexs
     * @return Map
     */
    public function addHex(Hex $hexs)
    {
        $this->hexs[] = $hexs;

        return $this;
    }

    /**
     * Remove hexs
     *
     * @param Hex $hexs
     */
    public function removeHex(Hex $hexs)
    {
        $this->hexs->removeElement($hexs);
    }

    /**
     * Get hexs
     *
     * @return Collection
     */
    public function getHexs()
    {
        return $this->hexs;
    }

    /**
     * Set campaign
     *
     * @param KingmakerCampaign $campaign
     * @return Map
     */
    public function setCampaign(KingmakerCampaign $campaign)
    {
        $this->campaign = $campaign;

        return $this;
    }

    /**
     * Get campaign
     *
     * @return KingmakerCampaign
     */
    public function getCampaign()
    {
        return $this->campaign;
    }
}
