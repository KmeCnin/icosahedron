<?php

namespace Ico\Bundle\KingmakerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations

/**
 * MapModel
 *
 * @ORM\Table(name="kingmaker_mapmodel")
 * @ORM\Entity(repositoryClass="Ico\Bundle\KingmakerBundle\Repository\MapModelRepository")
 */
class MapModel
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var text
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
     
    /**
    * @ORM\OneToOne(targetEntity="Dot", cascade={"persist", "merge", "remove"})
    */
    private $start;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="nbLines", type="integer")
     */
    private $nbLines;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="nbCols", type="integer")
     */
    private $nbCols;
    
    /**
     * @ORM\OneToMany(targetEntity="Map", mappedBy="mapModel", cascade={"persist"})
     */
    protected $maps;
    
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
     * Set name
     *
     * @param string $name
     * @return Campaign
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Campaign
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Campaign
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set nbLines
     *
     * @param integer $nbLines
     * @return MapModel
     */
    public function setNbLines($nbLines)
    {
        $this->nbLines = $nbLines;

        return $this;
    }

    /**
     * Get nbLines
     *
     * @return integer 
     */
    public function getNbLines()
    {
        return $this->nbLines;
    }

    /**
     * Set nbCols
     *
     * @param integer $nbCols
     * @return MapModel
     */
    public function setNbCols($nbCols)
    {
        $this->nbCols = $nbCols;

        return $this;
    }

    /**
     * Get nbCols
     *
     * @return integer 
     */
    public function getNbCols()
    {
        return $this->nbCols;
    }

    /**
     * Set start
     *
     * @param \Ico\Bundle\KingmakerBundle\Entity\Dot $start
     * @return MapModel
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->maps = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add maps
     *
     * @param \Ico\Bundle\KingmakerBundle\Entity\Map $maps
     * @return MapModel
     */
    public function addMap(\Ico\Bundle\KingmakerBundle\Entity\Map $maps)
    {
        $this->maps[] = $maps;

        return $this;
    }

    /**
     * Remove maps
     *
     * @param \Ico\Bundle\KingmakerBundle\Entity\Map $maps
     */
    public function removeMap(\Ico\Bundle\KingmakerBundle\Entity\Map $maps)
    {
        $this->maps->removeElement($maps);
    }

    /**
     * Get maps
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMaps()
    {
        return $this->maps;
    }
}
