<?php

namespace Ico\Bundle\MassFightBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ico\Bundle\KingmakerBundle\Entity\Campaign;
use Ico\Bundle\UserBundle\Entity\User;
use Symfony\Component\Security\Core\User\User as User2;
use Ico\Bundle\MassFightBundle\Model\Modificator;

/**
 * @ORM\Table(name="mass_fight_tactic")
 * @ORM\Entity(repositoryClass="Ico\Bundle\MassFightBundle\Repository\TacticRepository")
 */
class Tactic extends Modificator
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
     * @var bool 
     * 
     * @ORM\Column(type="boolean")
     */
    private $isDefault;
    
    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;
    
    public function __construct() {
        parent::__construct();
        $this->isDefault = false;
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
    
    public function getIsDefault()
    {
        return $this->isDefault;
    }
    
    public function isDefault()
    {
        return $this->isDefault;
    }
    
    public function setIsDefault($isDefault) {
        $this->isDefault = $isDefault;
        return $this;
    }
}
