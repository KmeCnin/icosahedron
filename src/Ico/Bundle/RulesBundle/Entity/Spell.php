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
     * @ORM\Column(name="detail", type="text")
     */
    private $detail;

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
     * @var string
     *
     * @ORM\Column(name="materialComponent", type="text", nullable=true)
     */
    protected $materialComponent;
    
    /**
	* @ORM\OneToOne(targetEntity="BattleTime", cascade={"persist", "remove"})
	*/
    protected $castingTime;
    
    /**
	* @var string
     * 
     * @ORM\Column(name="castingTimeSpecial", type="text", nullable=true)
	*/
    protected $castingTimeSpecial;
    
    /**
	* @ORM\ManyToOne(targetEntity="BattleRange", cascade={"persist", "remove"})
	*/
    protected $range;
    
    /**
	* @var string
     * 
     * @ORM\Column(name="rangeSpecial", type="text", nullable=true)
	*/
    protected $rangeSpecial;
    
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

    /**
     * Set detail
     *
     * @param string $detail
     * @return Spell
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
     * Set materialComponent
     *
     * @param string $materialComponent
     * @return Spell
     */
    public function setMaterialComponent($materialComponent)
    {
        $this->materialComponent = $materialComponent;

        return $this;
    }

    /**
     * Get materialComponent
     *
     * @return string 
     */
    public function getMaterialComponent()
    {
        return $this->materialComponent;
    }

    /**
     * Set castingTimeSpecial
     *
     * @param string $castingTimeSpecial
     * @return Spell
     */
    public function setCastingTimeSpecial($castingTimeSpecial)
    {
        $this->castingTimeSpecial = $castingTimeSpecial;

        return $this;
    }

    /**
     * Get castingTimeSpecial
     *
     * @return string 
     */
    public function getCastingTimeSpecial()
    {
        return $this->castingTimeSpecial;
    }

    /**
     * Set castingTime
     *
     * @param \Ico\Bundle\RulesBundle\Entity\BattleTime $castingTime
     * @return Spell
     */
    public function setCastingTime(\Ico\Bundle\RulesBundle\Entity\BattleTime $castingTime = null)
    {
        $this->castingTime = $castingTime;

        return $this;
    }

    /**
     * Get castingTime
     *
     * @return \Ico\Bundle\RulesBundle\Entity\BattleTime 
     */
    public function getCastingTime()
    {
        return $this->castingTime;
    }

    /**
     * Set rangeSpecial
     *
     * @param string $rangeSpecial
     * @return Spell
     */
    public function setRangeSpecial($rangeSpecial)
    {
        $this->rangeSpecial = $rangeSpecial;

        return $this;
    }

    /**
     * Get rangeSpecial
     *
     * @return string 
     */
    public function getRangeSpecial()
    {
        return $this->rangeSpecial;
    }

    /**
     * Set range
     *
     * @param \Ico\Bundle\RulesBundle\Entity\BattleRange $range
     * @return Spell
     */
    public function setRange(\Ico\Bundle\RulesBundle\Entity\BattleRange $range = null)
    {
        $this->range = $range;

        return $this;
    }

    /**
     * Get range
     *
     * @return \Ico\Bundle\RulesBundle\Entity\BattleRange 
     */
    public function getRange()
    {
        return $this->range;
    }
}
