<?php

namespace Ico\Bundle\RulesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Ability
 *
 * @ORM\Table(name="ability")
 * @ORM\Entity(repositoryClass="Ico\Bundle\RulesBundle\Repository\AbilityRepository")
 */
class Ability
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
     * @var string
     *
     * @ORM\Column(name="short", type="string", length=3)
     */
    private $short;

    /**
     * @var text
     *
     * @ORM\Column(name="applied", type="text")
     */
    private $applied;

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
     * @ORM\Column(name="mental", type="boolean")
     */
    private $mental;
    
    /**
     * @ORM\ManyToOne(targetEntity="Link", cascade={"remove", "persist"})
     */
    protected $link;


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
     * Set short
     *
     * @param string $short
     * @return Ability
     */
    public function setShort($short)
    {
        $this->short = $short;

        return $this;
    }

    /**
     * Get short
     *
     * @return string 
     */
    public function getShort()
    {
        return $this->short;
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
     * Is mental
     *
     * @return boolean 
     */
    public function isMental()
    {
        if ($this->mental) {
		  return 'oui';
	   }
	   return 'non';
    }

    /**
     * Set applied
     *
     * @param string $applied
     * @return Ability
     */
    public function setApplied($applied)
    {
        $this->applied = $applied;

        return $this;
    }

    /**
     * Get applied
     *
     * @return string 
     */
    public function getApplied()
    {
        return $this->applied;
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
}
