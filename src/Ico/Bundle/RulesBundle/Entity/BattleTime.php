<?php

namespace Ico\Bundle\RulesBundle\Entity;

use Doctrine\ORM\Mapping as ORM; use Gedmo\Mapping\Annotation as Gedmo;

/**
 * BattleTime
 *
 * @ORM\Table(name="battletime")
 * @ORM\Entity(repositoryClass="Ico\Bundle\RulesBundle\Repository\BattleTimeRepository")
 */ 
class BattleTime
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
     * @ORM\Column(name="value", type="integer")
     */
    private $value;
    
    /**
     * @ORM\ManyToOne(targetEntity="BattleUnit")
     * @ORM\JoinColumn(nullable=false)
     */
    private $unit;
    
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
     * Set value
     *
     * @param integer $value
     * @return BattleTime
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set unit
     *
     * @param \Ico\Bundle\RulesBundle\Entity\BattleUnit $unit
     * @return BattleTime
     */
    public function setUnit(\Ico\Bundle\RulesBundle\Entity\BattleUnit $unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return \Ico\Bundle\RulesBundle\Entity\BattleUnits 
     */
    public function getUnit()
    {
        return $this->unit;
    }
}
