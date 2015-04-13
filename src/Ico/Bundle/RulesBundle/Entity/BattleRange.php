<?php

namespace Ico\Bundle\RulesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serialize;

/**
 * BattleRange
 *
 * @ORM\Table(name="battlerange", indexes={@ORM\Index(name="nameId_idx", columns={"nameId"})})
 * @ORM\Entity(repositoryClass="Ico\Bundle\RulesBundle\Repository\BattleRangeRepository")
 * @Serialize\XmlRoot("battle_range")
 */ 
class BattleRange
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serialize\XmlAttribute
     * @Serialize\Type("integer")
     * @Serialize\Groups({"token"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Serialize\XmlAttribute
     * @Serialize\Type("string")
     * @Serialize\Groups({"token"})
     */
    private $name;
    
    /**
     * @Gedmo\Slug(fields={"nameId"})
     * @ORM\Column(name="slug", type="string", length=255)
     * @Serialize\XmlAttribute
     * @Serialize\Type("string")
     * @Serialize\Groups({"token"})
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="nameId", type="string", length=255)
     * @Serialize\XmlAttribute
     * @Serialize\Type("string")
     */
    private $nameId;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    
    /**
     * Constructor
     */
    public function __construct() {
        
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
     * Set nameId
     *
     * @param string $nameId
     * @return Range
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
     * Set name
     *
     * @param string $name
     * @return Range
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
     * @return Range
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
