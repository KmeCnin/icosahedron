<?php

namespace Ico\Bundle\RulesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpellList
 *
 * @ORM\Table(name="spelllist", indexes={@ORM\Index(name="nameId_idx", columns={"nameId"})})
 * @ORM\Entity(repositoryClass="Ico\Bundle\RulesBundle\Repository\SpellListRepository")
 */ 
class SpellList
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
     * @ORM\Column(name="short", type="string", length=255)
     */
    private $short;
    
    /**
     * @ORM\OneToMany(targetEntity="SpellListLevel", mappedBy="spellList", cascade={"persist", "remove"})
     */
    protected $spellListsLevels;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->spellListsLevels = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return SpellList
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
     * @return SpellList
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
     * Add spellListsLevels
     *
     * @param \Ico\Bundle\RulesBundle\Entity\SpellListLevel $spellListsLevels
     * @return SpellList
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
     * Set short
     *
     * @param string $short
     * @return SpellList
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
}
