<?php

namespace Ico\Bundle\RulesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serialize;

/**
 * CharacterClass
 *
 * @ORM\Table(name="characterclass", indexes={@ORM\Index(name="nameId_idx", columns={"nameId"})})
 * @ORM\Entity(repositoryClass="Ico\Bundle\RulesBundle\Repository\CharacterClassRepository")
 */
class CharacterClass
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
     * @Gedmo\Slug(fields={"nameId"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var text
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var text
     *
     * @ORM\Column(name="role", type="text")
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="alignment", type="string", length=255)
     */
    private $alignment;

    /**
     * @var string
     *
     * @ORM\Column(name="hitDie", type="string", length=255)
     */
    private $hitDie;

    /**
     * @var integer
     *
     * @ORM\Column(name="baseSkillPoints", type="integer")
     */
    private $baseSkillPoints;
    
    /**
     * @var ArrayCollection Skills $skills
     *
     * @ORM\ManyToMany(targetEntity="Skill", cascade={"persist", "merge", "remove"})
     */
    protected $skills;
    
    /**
     * @ORM\ManyToOne(targetEntity="Link", cascade={"remove", "persist"})
     */
    protected $link;

    /**
     * @var ArrayCollection CharacterClassLevel $levels
     *
     * @ORM\ManyToMany(targetEntity="CharacterClassLevel", cascade={"persist", "merge", "remove"})
     */
    protected $levels;
    
    /**
     * @var ArrayCollection CharacterClassSpecial $specials
     *
     * @ORM\OneToMany(targetEntity="CharacterClassSpecial", mappedBy="class", cascade={"remove", "persist"})
     */
    protected $specials;

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
     * @return Feat
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
     * Set description
     *
     * @param string $description
     * @return CharacterClass
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
     * Set name
     *
     * @param string $name
     * @return CharacterClass
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
     * Set alignment
     *
     * @param string $alignment
     * @return CharacterClass
     */
    public function setAlignment($alignment)
    {
        $this->alignment = $alignment;

        return $this;
    }

    /**
     * Get alignment
     *
     * @return string 
     */
    public function getAlignment()
    {
        return $this->alignment;
    }

    /**
     * Set hitDie
     *
     * @param string $hitDie
     * @return CharacterClass
     */
    public function setHitDie($hitDie)
    {
        $this->hitDie = $hitDie;

        return $this;
    }

    /**
     * Get hitDie
     *
     * @return string 
     */
    public function getHitDie()
    {
        return $this->hitDie;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->skills = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add skills
     *
     * @param \Ico\Bundle\RulesBundle\Entity\Skill $skills
     * @return CharacterClass
     */
    public function addSkill(\Ico\Bundle\RulesBundle\Entity\Skill $skills)
    {
        $this->skills[] = $skills;

        return $this;
    }

    /**
     * Remove skills
     *
     * @param \Ico\Bundle\RulesBundle\Entity\Skill $skills
     */
    public function removeSkill(\Ico\Bundle\RulesBundle\Entity\Skill $skills)
    {
        $this->skills->removeElement($skills);
    }

    /**
     * Get skills
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * Set link
     *
     * @param \Ico\Bundle\RulesBundle\Entity\Link $link
     * @return Ability
     */
    public function setLink(\Ico\Bundle\RulesBundle\Entity\Link $link = null)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return \Ico\Bundle\RulesBundle\Entity\Link 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return CharacterClass
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set baseSkillPoints
     *
     * @param integer $baseSkillPoints
     * @return CharacterClass
     */
    public function setBaseSkillPoints($baseSkillPoints)
    {
        $this->baseSkillPoints = $baseSkillPoints;

        return $this;
    }

    /**
     * Get baseSkillPoints
     *
     * @return integer 
     */
    public function getBaseSkillPoints()
    {
        return $this->baseSkillPoints;
    }

    /**
     * Add levels
     *
     * @param \Ico\Bundle\RulesBundle\Entity\CharacterClassLevel $levels
     * @return CharacterClass
     */
    public function addLevel(\Ico\Bundle\RulesBundle\Entity\CharacterClassLevel $levels)
    {
        $this->levels[] = $levels;

        return $this;
    }

    /**
     * Remove levels
     *
     * @param \Ico\Bundle\RulesBundle\Entity\CharacterClassLevel $levels
     */
    public function removeLevel(\Ico\Bundle\RulesBundle\Entity\CharacterClassLevel $levels)
    {
        $this->levels->removeElement($levels);
    }

    /**
     * Get levels
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLevels()
    {
        return $this->levels;
    }

    /**
     * Add specials
     *
     * @param \Ico\Bundle\RulesBundle\Entity\CharacterClassSpecial $specials
     * @return CharacterClass
     */
    public function addSpecial(\Ico\Bundle\RulesBundle\Entity\CharacterClassSpecial $specials)
    {
        $this->specials[] = $specials;

        return $this;
    }

    /**
     * Remove specials
     *
     * @param \Ico\Bundle\RulesBundle\Entity\CharacterClassSpecial $specials
     */
    public function removeSpecial(\Ico\Bundle\RulesBundle\Entity\CharacterClassSpecial $specials)
    {
        $this->specials->removeElement($specials);
    }

    /**
     * Get specials
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSpecials()
    {
        return $this->specials;
    }
}
