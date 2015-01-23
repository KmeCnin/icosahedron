<?php

namespace Ico\Bundle\RulesBundle\Entity;

use Doctrine\ORM\Mapping as ORM; 
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CharacterClassLevelSpecial
 *
 * @ORM\Table(name="characterclass_levelspecial")
 * @ORM\Entity(repositoryClass="Ico\Bundle\RulesBundle\Repository\CharacterClassLevelSpecialRepository")
 */ 
class CharacterClassLevelSpecial
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
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;
    
    /**
     * @ORM\ManyToOne(targetEntity="CharacterClassSpecial", cascade={"remove", "persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $special;
    
    /**
     * Constructor
     */
    public function __construct() {
        
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
     * Set label
     *
     * @param string $label
     * @return CharacterClassLevelSpecial
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string 
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set special
     *
     * @param \Ico\Bundle\RulesBundle\Entity\CharacterClassSpecial $special
     * @return CharacterClassLevelSpecial
     */
    public function setSpecial(\Ico\Bundle\RulesBundle\Entity\CharacterClassSpecial $special)
    {
        $this->special = $special;

        return $this;
    }

    /**
     * Get special
     *
     * @return \Ico\Bundle\RulesBundle\Entity\CharacterClassSpecial 
     */
    public function getSpecial()
    {
        return $this->special;
    }
}
