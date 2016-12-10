<?php

namespace Ico\Bundle\MassFightBundle\Entity; // gedmo annotations

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ico\Bundle\KingmakerBundle\Entity\Campaign;
use Ico\Bundle\RulesBundle\Entity\Alignment;
use Ico\Bundle\UserBundle\Entity\User;
use Tree\Fixture\User as User2;

/**
 * @ORM\Table(name="mass_fight_army")
 * @ORM\Entity(repositoryClass="Ico\Bundle\MassFightBundle\Repository\ArmyRepository")
 */
class Army
{
    const SIZE_INF  = 0;
    const SIZE_MIN  = 1;
    const SIZE_TP   = 2;
    const SIZE_P    = 3;
    const SIZE_M    = 4;
    const SIZE_G    = 5;
    const SIZE_TG   = 6;
    const SIZE_GIG  = 7;
    const SIZE_C    = 8;
    
    const D4    = 4;
    const D6    = 6;
    const D8    = 8;
    const D10   = 10;
    const D12   = 12;
                
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $xp;

    /**
     * @var Alignment
     *
     * @ORM\ManyToOne(targetEntity="\Ico\Bundle\RulesBundle\Entity\Alignment")
     * @ORM\JoinColumn(nullable=true)
     */
    private $alignment;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * Kind of die used for hp of the unit type.
     * (d4, d6, d8, d10, d12)
     * 
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $lifeDicesType;
    
    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Ico\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;
    
    public function __construct() {
        $this->size = self::SIZE_M;
        $this->lifeDicesType = self::D10;
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
     * Set name
     *
     * @param string $name
     * @return Campaign
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
     * Set created
     *
     * @param DateTime $created
     * @return User2
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param DateTime $updated
     * @return User2
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set createdBy
     *
     * @param \Ico\Bundle\UserBundle\User $createdBy
     * @return Campaign
     */
    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \Ico\Bundle\UserBundle\User 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Campaign
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
    
    public function getXp() {
        return $this->xp;
    }

    public function getAlignment() {
        return $this->alignment;
    }

    public function setXp($xp) {
        $this->xp = $xp;
        return $this;
    }

    public function setAlignment(Alignment $alignment) {
        $this->alignment = $alignment;
        return $this;
    }
    
    public function getSize() {
        return $this->size;
    }

    public function setSize($size) {
        $this->size = $size;
        return $this;
    }
    
    public static function getAllSizes()
    {
        return [
            self::SIZE_INF  => 'Infime',
            self::SIZE_MIN  => 'Minuscule',
            self::SIZE_TP   => 'Très petite',
            self::SIZE_P    => 'Petite',
            self::SIZE_M    => 'Moyenne',
            self::SIZE_G    => 'Grande',
            self::SIZE_TG   => 'Très grande',
            self::SIZE_GIG  => 'Gigantesque',
            self::SIZE_C    => 'Colossale',
        ];
    }
    
    public function getUnitNumberFromSize()
    {
        switch ($this->size) {
            case self::SIZE_INF:
                return 1;
            case self::SIZE_MIN:
                return 10;
            case self::SIZE_TP:
                return 25;
            case self::SIZE_P:
                return 50;
            case self::SIZE_M:
                return 100;
            case self::SIZE_G:
                return 200;
            case self::SIZE_TG:
                return 500;
            case self::SIZE_GIG:
                return 1000;
            case self::SIZE_C:
                return 2000;
        }
    }
    
    public function getFPAModFromSize()
    {
        switch ($this->size) {
            case self::SIZE_INF:
                return -8;
            case self::SIZE_MIN:
                return -6;
            case self::SIZE_TP:
                return -4;
            case self::SIZE_P:
                return -2;
            case self::SIZE_M:
                return 0;
            case self::SIZE_G:
                return 2;
            case self::SIZE_TG:
                return 4;
            case self::SIZE_GIG:
                return 6;
            case self::SIZE_C:
                return 8;
        }
    }
    
    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }
    
    public static function getAllDices()
    {
        return [
            self::D4    => 'd4',
            self::D6    => 'd6',
            self::D8    => 'd8',
            self::D10   => 'd10',
            self::D12   => 'd12',
        ];
    }
    
    public function getAverageHPFromDice()
    {
        return ($this->lifeDicesType+1)/2;
    }
    
    public function getBaseHP()
    {
        return floor($this->getAverageHPFromDice() * $this->getFpa());
    }
    
    public function getLifeDicesType() {
        return $this->lifeDicesType;
    }

    public function setLifeDicesType($lifeDicesType) {
        $this->lifeDicesType = $lifeDicesType;
        return $this;
    }
}
