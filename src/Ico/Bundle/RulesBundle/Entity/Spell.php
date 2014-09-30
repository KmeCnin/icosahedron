<?php

namespace Ico\Bundle\RulesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Spell
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ico\Bundle\RulesBundle\Repository\SpellRepository")
 */ 
class Spell
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="wiki", type="string", length=255)
     */
    private $wiki;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="target", type="text", nullable=true)
     */
    private $target;
    
    /**
     * @ORM\ManyToMany(targetEntity="SpellListLevel", cascade={"remove", "persist"})
     */
    protected $spellListsLevels;
    
    /**
    * @ORM\ManyToOne(targetEntity="SpellSchool", inversedBy="spells", cascade={"persist", "remove"})
    */
    protected $spellSchool;
    
    /**
     * @ORM\ManyToMany(targetEntity="SpellComponent", cascade={"remove", "persist"})
     */
    protected $spellComponents;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->featTypes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Spell
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
     * @return Spell
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
     * Set wiki
     *
     * @param string $wiki
     * @return Spell
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
     * Set description
     *
     * @param string $description
     * @return Spell
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
     * Set target
     *
     * @param string $target
     * @return Spell
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target
     *
     * @return string 
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Add spellListsLevels
     *
     * @param \Ico\Bundle\RulesBundle\Entity\SpellListLevel $spellListsLevels
     * @return Spell
     */
    public function addSpellListsLevel(\Ico\Bundle\RulesBundle\Entity\SpellListLevel $spellListsLevels)
    {
        $this->spellListsLevels[] = $spellListsLevels;

        return $this;
    }

    /**
     * Remove spellListsLevels
     *
     * @param \Ico\Bundle\RulesBundle\Entity\SpellListLevel $spellListsLevels
     */
    public function removeSpellListsLevel(\Ico\Bundle\RulesBundle\Entity\SpellListLevel $spellListsLevels)
    {
        $this->spellListsLevels->removeElement($spellListsLevels);
    }

    /**
     * Get spellListsLevels
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSpellListsLevels()
    {
        return $this->spellListsLevels;
    }

    /**
     * Set spellSchool
     *
     * @param \Ico\Bundle\RulesBundle\Entity\SpellSchool $spellSchool
     * @return Spell
     */
    public function setSpellSchool(\Ico\Bundle\RulesBundle\Entity\SpellSchool $spellSchool = null)
    {
        $this->spellSchool = $spellSchool;

        return $this;
    }

    /**
     * Get spellSchool
     *
     * @return \Ico\Bundle\RulesBundle\Entity\SpellSchool 
     */
    public function getSpellSchool()
    {
        return $this->spellSchool;
    }

    /**
     * Add spellComponents
     *
     * @param \Ico\Bundle\RulesBundle\Entity\SpellComponent $spellComponents
     * @return Spell
     */
    public function addSpellComponent(\Ico\Bundle\RulesBundle\Entity\SpellComponent $spellComponents)
    {
        $this->spellComponents[] = $spellComponents;

        return $this;
    }

    /**
     * Remove spellComponents
     *
     * @param \Ico\Bundle\RulesBundle\Entity\SpellComponent $spellComponents
     */
    public function removeSpellComponent(\Ico\Bundle\RulesBundle\Entity\SpellComponent $spellComponents)
    {
        $this->spellComponents->removeElement($spellComponents);
    }

    /**
     * Get spellComponents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSpellComponents()
    {
        return $this->spellComponents;
    }
}
