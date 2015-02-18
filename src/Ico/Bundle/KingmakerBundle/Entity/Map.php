<?php

namespace Ico\Bundle\KingmakerBundle\Entity;

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
     * @ORM\ManyToOne(targetEntity="MapModel", cascade={"remove"}, inversedBy="maps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mapModel;
    
    /**
     * @ORM\ManyToOne(targetEntity="Campaign", cascade={"remove"}, inversedBy="maps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campaign;
    
    /**
     * @ORM\OneToMany(targetEntity="Hex", mappedBy="map", cascade={"persist"})
     */
    protected $hexs;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->hexs = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param \Ico\Bundle\KingmakerBundle\Entity\MapModel $mapModel
     * @return Map
     */
    public function setMapModel(\Ico\Bundle\KingmakerBundle\Entity\MapModel $mapModel)
    {
        $this->mapModel = $mapModel;

        return $this;
    }

    /**
     * Get mapModel
     *
     * @return \Ico\Bundle\KingmakerBundle\Entity\MapModel 
     */
    public function getMapModel()
    {
        return $this->mapModel;
    }

    /**
     * Add hexs
     *
     * @param \Ico\Bundle\KingmakerBundle\Entity\Hex $hexs
     * @return Map
     */
    public function addHex(\Ico\Bundle\KingmakerBundle\Entity\Hex $hexs)
    {
        $this->hexs[] = $hexs;

        return $this;
    }

    /**
     * Remove hexs
     *
     * @param \Ico\Bundle\KingmakerBundle\Entity\Hex $hexs
     */
    public function removeHex(\Ico\Bundle\KingmakerBundle\Entity\Hex $hexs)
    {
        $this->hexs->removeElement($hexs);
    }

    /**
     * Get hexs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHexs()
    {
        return $this->hexs;
    }

    /**
     * Set campaign
     *
     * @param \Ico\Bundle\KingmakerBundle\Entity\Campaign $campaign
     * @return Map
     */
    public function setCampaign(\Ico\Bundle\KingmakerBundle\Entity\Campaign $campaign)
    {
        $this->campaign = $campaign;

        return $this;
    }

    /**
     * Get campaign
     *
     * @return \Ico\Bundle\KingmakerBundle\Entity\Campaign 
     */
    public function getCampaign()
    {
        return $this->campaign;
    }
}
