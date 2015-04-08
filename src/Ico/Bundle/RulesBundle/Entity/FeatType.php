<?php

namespace Ico\Bundle\RulesBundle\Entity;

use Doctrine\ORM\Mapping as ORM; 
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serialize;

/**
 * FeatType
 *
 * @ORM\Table(name="feattype", indexes={@ORM\Index(name="nameId_idx", columns={"nameId"})})
 * @ORM\Entity(repositoryClass="Ico\Bundle\RulesBundle\Repository\FeatTypeRepository")
 * @Serialize\XmlRoot("feat_type")
 */ 
class FeatType
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serialize\XmlAttribute
     * @Serialize\Type("integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nameId", type="string", length=255)
     * @Serialize\XmlAttribute
     * @Serialize\Type("string")
     */
    private $nameId; 
    
    /**
     * @Gedmo\Slug(fields={"nameId"})
     * @ORM\Column(name="slug", type="string", length=255)
     * @Serialize\XmlAttribute
     * @Serialize\Type("string")
     */
    private $slug; 

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Serialize\XmlAttribute
     * @Serialize\Type("string")
     */
    private $name;  

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;  

    /**
     * @var string
     *
     * @ORM\Column(name="detail", type="text", nullable=true)
     */
    private $detail; 
    
    /**
     * @var ArrayCollection FeatType $feats
     * Inverse Side
     *
     * @ORM\ManyToMany(targetEntity="Feat", mappedBy="featTypes", cascade={"persist", "merge", "remove"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @Serialize\Exclude
     */
    private $feats;

    /**
     * @var string
     *
     * @ORM\Column(name="wiki", type="string", length=255, nullable=true)
     * @Serialize\XmlAttribute
     * @Serialize\Type("string")
     */
    private $wiki; 
    
    /**
     * Constructor
     */
    public function __construct()
    {
        
        $this->feats = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return FeatType
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
     * @return FeatType
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
     * Set wiki
     *
     * @param string $wiki
     * @return FeatType
     */
    public function setWiki($wiki)
    {
        $this->wiki = $wiki;

        return $this;
    }

    /**
     * Get wiki
     *
     * @return string 
     */
    public function getWiki()
    {
        return $this->wiki;
    }

    /**
     * Set nameId
     *
     * @param string $nameId
     * @return FeatType
     */
    public function setNameId($nameId)
    {
        $this->nameId = $nameId;

        return $this;
    }

    /**
     * Get nameId
     *
     * @return string 
     */
    public function getNameId()
    {
        return $this->nameId;
    }

    /**
     * Set detail
     *
     * @param string $detail
     * @return FeatType
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * Get detail
     *
     * @return string 
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * Add feats
     *
     * @param \Ico\Bundle\RulesBundle\Entity\Feat $feats
     * @return FeatType
     */
    public function addFeat(\Ico\Bundle\RulesBundle\Entity\Feat $feats)
    {
        $this->feats[] = $feats;

        return $this;
    }

    /**
     * Remove feats
     *
     * @param \Ico\Bundle\RulesBundle\Entity\Feat $feats
     */
    public function removeFeat(\Ico\Bundle\RulesBundle\Entity\Feat $feats)
    {
        $this->feats->removeElement($feats);
    }

    /**
     * Get feats
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFeats()
    {
        return $this->feats;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return BattleRange
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
}
