<?php

namespace Ico\Bundle\KingmakerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations

/**
 * Realm
 *
 * @ORM\Table(name="kingmaker_realm")
 * @ORM\Entity(repositoryClass="Ico\Bundle\KingmakerBundle\Repository\RealmRepository")
 */
class Realm
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
     * @ORM\ManyToOne(targetEntity="\Ico\Bundle\UserBundle\Entity\Alignment")
     */
    private $alignment;

    /**    
     * @var integer
     * 
     * @ORM\Column(name="size", type="integer")
     */
    private $size;
    
    /**    
     * @var integer
     * 
     * @ORM\Column(name="size", type="integer")
     */
    private $controlSavingThrow;
    
    /**    
     * @var integer
     * 
     * @ORM\Column(name="size", type="integer")
     */
    private $population;
    
    /**    
     * @var integer
     * 
     * @ORM\Column(name="stability", type="integer")
     */
    private $stability;
    
    /**    
     * @var integer
     * 
     * @ORM\Column(name="economy", type="integer")
     */
    private $economy;
    
    /**    
     * @var integer
     * 
     * @ORM\Column(name="loyalty", type="integer")
     */
    private $loyalty;
    
    /**    
     * @var integer
     * 
     * @ORM\Column(name="dissatisfaction", type="integer")
     */
    private $dissatisfaction;
    
    /**    
     * @var integer
     * 
     * @ORM\Column(name="uptake", type="integer")
     */
    private $uptake;
    
    /**    
     * @var integer
     * 
     * @ORM\Column(name="treasury", type="integer")
     */
    private $treasury;
    
    /**
     * @ORM\ManyToOne(targetEntity="Campaign", inversedBy="maps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campaign;

    /**
     * @ORM\Column(name="created", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created;

    /**
     * @ORM\Column(name="updated", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;
    
    public function updateControlSavingThrow() {
	   $value = $this->size + 20;
	   $this->setControlSavingThrow($value);
    }
    
    public function updatePopulation() {
	   $value = $this->size * 250; // TODO + population de chaque ville
	   $this->setPopulation($value);
    }
    
}
