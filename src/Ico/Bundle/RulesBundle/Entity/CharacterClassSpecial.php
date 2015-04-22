<?php

namespace Ico\Bundle\RulesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serialize;

/**
 * CharacterClassSpecial
 *
 * @ORM\Table(name="characterclass_special", indexes={@ORM\Index(name="nameId_idx", columns={"nameId"})})
 * @ORM\Entity(repositoryClass="Ico\Bundle\RulesBundle\Repository\CharacterClassSpecialRepository")
 */
class CharacterClassSpecial
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
     * @var string
     *
     * @ORM\Column(name="nameId", type="string", length=255)
     */
    private $nameId;

    /**
     * @var text
     *
     * @ORM\Column(name="detail", type="text")
     */
    private $detail;

    /**
     * @var text
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
    /**
     * @var ArrayCollection CharacterClass $specials
     *
     * @ORM\ManyToOne(targetEntity="CharacterClass", inversedBy="specials", cascade={"remove", "persist"})
     */
    protected $class;


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
     * @return CharacterClassSpecial
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
     * @return CharacterClassSpecial
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
     * Set description
     *
     * @param string $description
     * @return CharacterClassSpecial
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
     * Set nameId
     *
     * @param string $nameId
     * @return CharacterClassSpecial
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
     * @return CharacterClassSpecial
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
     * Set class
     *
     * @param \Ico\Bundle\RulesBundle\Entity\CharacterClass $class
     * @return CharacterClassSpecial
     */
    public function setClass(\Ico\Bundle\RulesBundle\Entity\CharacterClass $class = null)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return \Ico\Bundle\RulesBundle\Entity\CharacterClass 
     */
    public function getClass()
    {
        return $this->class;
    }
}
