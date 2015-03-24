<?php

namespace Ico\Bundle\RulesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Skill
 *
 * @ORM\Table(name="skill")
 * @ORM\Entity(repositoryClass="Ico\Bundle\RulesBundle\Repository\SkillRepository")
 */
class Skill
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
     * @ORM\ManyToOne(targetEntity="Link", cascade={"remove", "persist"})
     */
    protected $link;

    /**
     * @var text
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var text
     *
     * @ORM\Column(name="detail", type="text")
     */
    private $detail;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="untrained", type="boolean")
     */
    private $untrained;
    
    /**
     * @var ability
     * 
     * @ORM\ManyToOne(targetEntity="Ability")
     */
    private $ability;

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
     * Set detail
     *
     * @param string $detail
     * @return Ability
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
     * Set mental
     *
     * @param boolean $mental
     * @return Ability
     */
    public function setMental($mental)
    {
        $this->mental = $mental;

        return $this;
    }

    /**
     * Get mental
     *
     * @return boolean 
     */
    public function getMental()
    {
        return $this->mental;
    }

    /**
     * Set untrained
     *
     * @param boolean $untrained
     * @return Skill
     */
    public function setUntrained($untrained)
    {
        $this->untrained = $untrained;

        return $this;
    }

    /**
     * Get untrained
     *
     * @return boolean 
     */
    public function getUntrained()
    {
        return $this->untrained;
    }

    /**
     * Is untrained
     *
     * @return boolean 
     */
    public function isUntrained()
    {
        if ($this->untrained) {
		  return 'oui';
	   }
	   return 'non';
    }

    /**
     * Set ability
     *
     * @param \Ico\Bundle\RulesBundle\Entity\Ability $ability
     * @return Skill
     */
    public function setAbility(\Ico\Bundle\RulesBundle\Entity\Ability $ability)
    {
        $this->ability = $ability;

        return $this;
    }

    /**
     * Get ability
     *
     * @return \Ico\Bundle\RulesBundle\Entity\Ability 
     */
    public function getAbility()
    {
        return $this->ability;
    }

    /**
     * Set link
     *
     * @param \Ico\Bundle\RulesBundle\Entity\Link $link
     * @return Skill
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
}
