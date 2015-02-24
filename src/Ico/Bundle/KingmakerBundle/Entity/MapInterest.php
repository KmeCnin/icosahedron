<?php

namespace Ico\Bundle\KingmakerBundle\Entity; // gedmo annotations


use Doctrine\ORM\Mapping as ORM;
use Ico\Bundle\KingmakerBundle\Repository\MapInterestRepository;
use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations

/**
 * MapInterest
 *
 * @ORM\Table(name="kingmaker_mapinterest")
 * @ORM\Entity(repositoryClass="MapInterestRepository")
 */
class MapInterest
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
     * @ORM\Column(name="name", type="string", length=25)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;
    
    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;
    
    /**
     * @ORM\ManyToOne(targetEntity="MapInterestModel", inversedBy="mapInterests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mapInterestModel;
    
    /**
     * @ORM\ManyToOne(targetEntity="Hex", inversedBy="mapInterests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hex;
     
    /**
    * @ORM\OneToOne(targetEntity="Dot", cascade={"persist", "merge", "remove"})
    */
    private $position;
    
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
     * @return MapInterest
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
     * Set slug
     *
     * @param string $slug
     * @return MapInterest
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
     * Set mapInterestModel
     *
     * @param MapInterestModel $mapInterestModel
     * @return MapInterest
     */
    public function setMapInterestModel(MapInterestModel $mapInterestModel)
    {
        $this->mapInterestModel = $mapInterestModel;

        return $this;
    }

    /**
     * Get mapInterestModel
     *
     * @return MapInterestModel 
     */
    public function getMapInterestModel()
    {
        return $this->mapInterestModel;
    }

    /**
     * Set hex
     *
     * @param Hex $hex
     * @return MapInterest
     */
    public function setHex(Hex $hex)
    {
        $this->hex = $hex;

        return $this;
    }

    /**
     * Get hex
     *
     * @return Hex 
     */
    public function getHex()
    {
        return $this->hex;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return MapInterest
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
     * Set position
     *
     * @param Dot $position
     * @return MapInterest
     */
    public function setPosition(Dot $position = null)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return Dot 
     */
    public function getPosition()
    {
        return $this->position;
    }
}
