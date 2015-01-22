<?php

namespace Ico\Bundle\RulesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CharacterClassLevel
 *
 * @ORM\Table(name="characterclass_level", indexes={@ORM\Index(name="level_idx", columns={"level"})})
 * @ORM\Entity(repositoryClass="Ico\Bundle\RulesBundle\Repository\CharacterClassLevelRepository")
 */
class CharacterClassLevel
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
     * @var integer
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

    /**
     * @var integer
     *
     * @ORM\Column(name="bba", type="integer")
     */
    private $bba;

    /**
     * @var integer
     *
     * @ORM\Column(name="ref", type="integer")
     */
    private $ref;

    /**
     * @var integer
     *
     * @ORM\Column(name="vig", type="integer")
     */
    private $vig;

    /**
     * @var integer
     *
     * @ORM\Column(name="vol", type="integer")
     */
    private $vol;
    
    /**
     * @var ArrayCollection CharacterClassSpecial $specials
     *
     * @ORM\ManyToMany(targetEntity="CharacterClassSpecial", cascade={"persist", "merge", "remove"})
     */
    protected $specials;

    /**
     * @var array
     *
     * @ORM\Column(name="dailySpells", type="array")
     */
    private $dailySpells;

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
     * @return CharacterClassLevel
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
     * Set bba
     *
     * @param integer $bba
     * @return CharacterClassLevel
     */
    public function setBba($bba)
    {
        $this->bba = $bba;

        return $this;
    }

    /**
     * Get bba
     *
     * @return integer 
     */
    public function getBba()
    {
        return $this->bba;
    }

    /**
     * Set ref
     *
     * @param integer $ref
     * @return CharacterClassLevel
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * Get ref
     *
     * @return integer 
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Set vig
     *
     * @param integer $vig
     * @return CharacterClassLevel
     */
    public function setVig($vig)
    {
        $this->vig = $vig;

        return $this;
    }

    /**
     * Get vig
     *
     * @return integer 
     */
    public function getVig()
    {
        return $this->vig;
    }

    /**
     * Set vol
     *
     * @param integer $vol
     * @return CharacterClassLevel
     */
    public function setVol($vol)
    {
        $this->vol = $vol;

        return $this;
    }

    /**
     * Get vol
     *
     * @return integer 
     */
    public function getVol()
    {
        return $this->vol;
    }

    /**
     * Set dailySpells
     *
     * @param array $dailySpells
     * @return CharacterClassLevel
     */
    public function setDailySpells($dailySpells)
    {
        $this->dailySpells = $dailySpells;

        return $this;
    }

    /**
     * Get dailySpells
     *
     * @return array 
     */
    public function getDailySpells()
    {
        return $this->dailySpells;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->specials = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add specials
     *
     * @param \Ico\Bundle\RulesBundle\Entity\CharacterClassSpecial $specials
     * @return CharacterClassLevel
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
