<?php

namespace Ico\Bundle\KingmakerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations

/**
 * MapInterest
 *
 * @ORM\Table(name="kingmaker_mapinterest")
 * @ORM\Entity(repositoryClass="Ico\Bundle\KingmakerBundle\Repository\MapInterestRepository")
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
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
     * @param \Ico\Bundle\KingmakerBundle\Entity\MapInterestModel $mapInterestModel
     * @return MapInterest
     */
    public function setMapInterestModel(\Ico\Bundle\KingmakerBundle\Entity\MapInterestModel $mapInterestModel)
    {
        $this->mapInterestModel = $mapInterestModel;

        return $this;
    }

    /**
     * Get mapInterestModel
     *
     * @return \Ico\Bundle\KingmakerBundle\Entity\MapInterestModel 
     */
    public function getMapInterestModel()
    {
        return $this->mapInterestModel;
    }

    /**
     * Set hex
     *
     * @param \Ico\Bundle\KingmakerBundle\Entity\Hex $hex
     * @return MapInterest
     */
    public function setHex(\Ico\Bundle\KingmakerBundle\Entity\Hex $hex)
    {
        $this->hex = $hex;

        return $this;
    }

    /**
     * Get hex
     *
     * @return \Ico\Bundle\KingmakerBundle\Entity\Hex 
     */
    public function getHex()
    {
        return $this->hex;
    }
}
