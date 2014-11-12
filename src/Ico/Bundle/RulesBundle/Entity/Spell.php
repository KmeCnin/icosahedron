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
     * @ORM\ManyToMany(targetEntity="Link", cascade={"remove", "persist"})
     */
    protected $links;

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
	* @var string
     * 
     * @ORM\Column(name="duration", type="string", length=255, nullable=true)
	*/
    protected $duration;
    
    /**
	* @ORM\ManyToOne(targetEntity="SavingThrow", cascade={"persist", "remove"})
	*/
    protected $savingThrow;
    
    /**
	* @var string
     * 
     * @ORM\Column(name="savingThrowSpecial", type="text", nullable=true)
	*/
    protected $savingThrowSpecial;
    
    /**
	* @ORM\ManyToOne(targetEntity="SavingThrowEffect", cascade={"persist", "remove"})
	*/
    protected $savingThrowEffect;
    
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
     * Set duration
     *
     * @param string $duration
     * @return Spell
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return string 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set savingThrowSpecial
     *
     * @param string $savingThrowSpecial
     * @return Spell
     */
    public function setSavingThrowSpecial($savingThrowSpecial)
    {
        $this->savingThrowSpecial = $savingThrowSpecial;

        return $this;
    }

    /**
     * Get savingThrowSpecial
     *
     * @return string 
     */
    public function getSavingThrowSpecial()
    {
        return $this->savingThrowSpecial;
    }

    /**
     * Add links
     *
     * @param \Ico\Bundle\RulesBundle\Entity\Link $links
     * @return Spell
     */
    public function addLink(\Ico\Bundle\RulesBundle\Entity\Link $links)
    {
        $this->links[] = $links;

        return $this;
    }

    /**
     * Remove links
     *
     * @param \Ico\Bundle\RulesBundle\Entity\Link $links
     */
    public function removeLink(\Ico\Bundle\RulesBundle\Entity\Link $links)
    {
        $this->links->removeElement($links);
    }

    /**
     * Get links
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLinks()
    {
        return $this->links;
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

    /**
     * Set savingThrow
     *
     * @param \Ico\Bundle\RulesBundle\Entity\SavingThrow $savingThrow
     * @return Spell
     */
    public function setSavingThrow(\Ico\Bundle\RulesBundle\Entity\SavingThrow $savingThrow = null)
    {
        $this->savingThrow = $savingThrow;

        return $this;
    }

    /**
     * Get savingThrow
     *
     * @return \Ico\Bundle\RulesBundle\Entity\SavingThrow 
     */
    public function getSavingThrow()
    {
        return $this->savingThrow;
    }

    /**
     * Set savingThrowEffect
     *
     * @param \Ico\Bundle\RulesBundle\Entity\SavingThrowEffect $savingThrowEffect
     * @return Spell
     */
    public function setSavingThrowEffect(\Ico\Bundle\RulesBundle\Entity\SavingThrowEffect $savingThrowEffect = null)
    {
        $this->savingThrowEffect = $savingThrowEffect;

        return $this;
    }

    /**
     * Get savingThrowEffect
     *
     * @return \Ico\Bundle\RulesBundle\Entity\SavingThrowEffect 
     */
    public function getSavingThrowEffect()
    {
        return $this->savingThrowEffect;
    }
}
