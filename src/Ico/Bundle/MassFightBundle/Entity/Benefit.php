<?php

namespace Ico\Bundle\MassFightBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ico\Bundle\MassFightBundle\Model\Modificator;

/**
 * @ORM\Table(name="mass_fight_benefits")
 * @ORM\Entity(repositoryClass="Ico\Bundle\MassFightBundle\Repository\BenefitRepository")
 */
class Benefit extends Modificator
{                
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
    protected $name;
    
    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    protected $fp;
    
    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    protected $ma;
    
    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    protected $damages;
    
    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    protected $vd;
    
    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    protected $moral;
    
    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    protected $speed;
    
    /**
     * @var int
     * 
     * @ORM\Column(type="integer")
     */
    protected $conso;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $minPrestige;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $isAllele;
    
    public function __construct() {
        parent::__construct();
        $this->minPrestige = 0;
        $this->isAllele = false;
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
     * Set slug
     *
     * @param string $slug
     * @return Benefit
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
     * @return int
     */
    public function getMinPrestige()
    {
        return $this->minPrestige;
    }

    /**
     * @param int $minPrestige
     *
     * @return $this
     */
    public function setMinPrestige($minPrestige)
    {
        $this->minPrestige = $minPrestige;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsAllele()
    {
        return $this->isAllele;
    }

    /**
     * @param $isAllele
     * @return $this
     */
    public function setIsAllele($isAllele)
    {
        $this->isAllele = $isAllele;

        return $this;
    }
}
