<?php

namespace Ico\Bundle\KingmakerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations

/**
 * MapInterestModel
 *
 * @ORM\Table(name="kingmaker_mapinterestmodel")
 * @ORM\Entity(repositoryClass="Ico\Bundle\KingmakerBundle\Repository\MapInterestModelRepository")
 */
class MapInterestModel
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
     * @ORM\OneToMany(targetEntity="MapInterest", mappedBy="mapInterestModel", cascade={"persist"})
     */
    protected $mapInterests;

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
     * Constructor
     */
    public function __construct()
    {
        $this->mapInterests = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add mapInterests
     *
     * @param \Ico\Bundle\KingmakerBundle\Entity\MapInterest $mapInterests
     * @return MapInterestModel
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
}
