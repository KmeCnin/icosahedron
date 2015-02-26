<?php

namespace Ico\Bundle\KingmakerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations

/**
 * Hex
 *
 * @ORM\Table(name="kingmaker_hex")
 * @ORM\Entity(repositoryClass="Ico\Bundle\KingmakerBundle\Repository\HexRepository")
 */
class Hex
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
     * @ORM\ManyToOne(targetEntity="Map", cascade={"remove"}, inversedBy="hexs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $map;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="x", type="integer")
     */
    private $x;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="y", type="integer")
     */
    private $y;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="explored", type="boolean")
     */
    private $explored;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="annexed", type="boolean")
     */
    private $annexed;
    
    /**
     * @ORM\OneToMany(targetEntity="MapInterest", mappedBy="hex", cascade={"persist", "remove"})
     */
    protected $mapInterests;
     
    /**
    * @ORM\OneToOne(targetEntity="Dot", cascade={"persist", "merge", "remove"})
    */
    private $start;
    
    public function __construct($x = null, $y = null) {
        
        $this->setX($x);
        $this->setY($y);
        $this->setExplored(false);
        $this->setAnnexed(false);
        
        return $this;
    }
    
    public function getWidth() {
        $map_model = $this->getMap()->getMapModel();
        return sqrt(($map_model->getHexSide() * $map_model->getHexSide()) - (($map_model->getHexSide() * 0.5) * ($map_model->getHexSide() * 0.5))) * 2;
    }
    
    public function getHeight() {
        $map_model = $this->getMap()->getMapModel();
        return $map_model->getHexSide() * 2;
    }
    
    public function getMinX() {
        return $this->getStart()->getX();
    }
    public function getCenterX() {
        return $this->getStart()->getX() + ($this->getWidth() / 2);
    }
    public function getMaxX() {
        return $this->getStart()->getX() + $this->getWidth();
    }
    
    public function getMinY() {
        return $this->getStart()->getY() - ($this->getHeight() / 4);
    }
    public function getCenterY() {
        return $this->getStart()->getY() + ($this->getHeight() / 4);
    }
    public function getMaxY() {
        return $this->getStart()->getY() + 3 * ($this->getHeight() / 4);
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
     * Set x
     *
     * @param integer $x
     * @return Dot
     */
    public function setX($x)
    {
        $this->x = $x;

        return $this;
    }

    /**
     * Get x
     *
     * @return integer 
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Set y
     *
     * @param integer $y
     * @return Dot
     */
    public function setY($y)
    {
        $this->y = $y;

        return $this;
    }

    /**
     * Get y
     *
     * @return integer 
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Set map
     *
     * @param \Ico\Bundle\KingmakerBundle\Entity\Map $map
     * @return Hex
     */
    public function setMap(\Ico\Bundle\KingmakerBundle\Entity\Map $map)
    {
        $this->map = $map;

        return $this;
    }

    /**
     * Get map
     *
     * @return \Ico\Bundle\KingmakerBundle\Entity\Map 
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Set explored
     *
     * @param boolean $explored
     * @return Hex
     */
    public function setExplored($explored)
    {
        $this->explored = $explored;

        return $this;
    }

    /**
     * Get explored
     *
     * @return boolean 
     */
    public function getExplored()
    {
        return $this->explored;
    }

    /**
     * Set annexed
     *
     * @param boolean $annexed
     * @return Hex
     */
    public function setAnnexed($annexed)
    {
        $this->annexed = $annexed;

        return $this;
    }

    /**
     * Get annexed
     *
     * @return boolean 
     */
    public function getAnnexed()
    {
        return $this->annexed;
    }

    /**
     * Add mapInterests
     *
     * @param \Ico\Bundle\KingmakerBundle\Entity\MapInterest $mapInterests
     * @return Hex
     */
    public function addMapInterest(\Ico\Bundle\KingmakerBundle\Entity\MapInterest $mapInterests)
    {
        $this->mapInterests[] = $mapInterests;

        return $this;
    }

    /**
     * Remove mapInterests
     *
     * @param \Ico\Bundle\KingmakerBundle\Entity\MapInterest $mapInterests
     */
    public function removeMapInterest(\Ico\Bundle\KingmakerBundle\Entity\MapInterest $mapInterests)
    {
        $this->mapInterests->removeElement($mapInterests);
    }

    /**
     * Get mapInterests
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMapInterests()
    {
        return $this->mapInterests;
    }

    /**
     * Set start
     *
     * @param \Ico\Bundle\KingmakerBundle\Entity\Dot $start
     * @return Hex
     */
    public function setStart(\Ico\Bundle\KingmakerBundle\Entity\Dot $start = null)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \Ico\Bundle\KingmakerBundle\Entity\Dot 
     */
    public function getStart()
    {
        return $this->start;
    }
}
