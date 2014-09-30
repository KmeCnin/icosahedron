<?php

namespace Ico\Bundle\RulesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpellListLevel
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ico\Bundle\RulesBundle\Repository\SpellListLevelRepository")
 */ 
class SpellListLevel
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
    * @ORM\ManyToOne(targetEntity="SpellList", inversedBy="spellListsLevels", cascade={"remove"})
    */
    protected $spellList;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

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
     * Set level
     *
     * @param integer $level
     * @return SpellListLevel
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set spellList
     *
     * @param \Ico\Bundle\RulesBundle\Entity\SpellList $spellList
     * @return SpellListLevel
     */
    public function setSpellList(\Ico\Bundle\RulesBundle\Entity\SpellList $spellList = null)
    {
        $this->spellList = $spellList;

        return $this;
    }

    /**
     * Get spellList
     *
     * @return \Ico\Bundle\RulesBundle\Entity\SpellList 
     */
    public function getSpellList()
    {
        return $this->spellList;
    }
}
