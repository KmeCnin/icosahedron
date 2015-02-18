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
    
    public function __construct($x = null, $y = null) {
        
        $this->setX($x);
        $this->setY($y);
        $this->setExplored(false);
        
        return $this;
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
}
