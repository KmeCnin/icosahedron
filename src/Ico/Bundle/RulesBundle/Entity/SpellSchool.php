<?php

namespace Ico\Bundle\RulesBundle\Entity;

use Doctrine\ORM\Mapping as ORM; 
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SpellSchool
 *
 * @ORM\Table(name="spellschool", indexes={@ORM\Index(name="nameId_idx", columns={"nameId"})})
 * @ORM\Entity(repositoryClass="Ico\Bundle\RulesBundle\Repository\SpellSchoolRepository")
 */ 
class SpellSchool
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
     * @ORM\Column(name="nameId", type="string", length=255)
     */
    private $nameId;
    
    /**
     * @Gedmo\Slug(fields={"nameId"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
    /**
     * @var string
     *
     * @ORM\Column(name="detail", type="text", nullable=true)
     */
    private $detail; 
    
    /**
    * @ORM\OneToMany(targetEntity="Spell", mappedBy="spellSchool", cascade={"persist", "remove"})
    */
    protected $spells;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        
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
     * @return SpellSchool
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
     * @return SpellSchool
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
     * @return SpellSchool
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
     * Set detail
     *
     * @param string $detail
     * @return SpellSchool
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

    /**
     * Add spells
     *
     * @param \Ico\Bundle\RulesBundle\Entity\Spell $spells
     * @return SpellSchool
     */
    public function addSpell(\Ico\Bundle\RulesBundle\Entity\Spell $spells)
    {
        $this->spells[] = $spells;

        return $this;
    }

    /**
     * Remove spells
     *
     * @param \Ico\Bundle\RulesBundle\Entity\Spell $spells
     */
    public function removeSpell(\Ico\Bundle\RulesBundle\Entity\Spell $spells)
    {
        $this->spells->removeElement($spells);
    }

    /**
     * Get spells
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSpells()
    {
        return $this->spells;
    }
}
