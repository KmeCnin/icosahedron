<?php

namespace Ico\Bundle\RulesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpellSchool
 *
 * @ORM\Table(name="spellschool", indexes={@ORM\Index(name="nameId_idx", columns={"nameId"})})
 * @ORM\Entity(repositoryClass="Ico\Bundle\RulesBundle\Repository\SpellSchoolRepository")
 */ 
class SpellSchool extends Normalized
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
    /**
     * @var string
     *
     * @ORM\Column(name="detail", type="text", nullable=true)
     */
    private $detail; 
    
    /**
    * @ORM\OneToMany(targetEntity="Spell", mappedBy="spellSchool", cascade={"persist", "remove"})
    */
    protected $spells;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
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
     * @return SpellSchool
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
     * @return SpellSchool
     */
    public function setName($name)
    {
        $this->name = $name;
	   $this->setSlug($this->name);

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
     * @return SpellSchool
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
     * @return SpellSchool
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
}
