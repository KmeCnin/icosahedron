<?php

namespace Ico\Bundle\MassFightBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ico\Bundle\KingmakerBundle\Entity\Campaign;
use Ico\Bundle\RulesBundle\Entity\Alignment;
use Ico\Bundle\UserBundle\Entity\User;
use Symfony\Component\Security\Core\User\User as User2;

/**
 * @ORM\Table(name="mass_fight_commander")
 * @ORM\Entity(repositoryClass="Ico\Bundle\MassFightBundle\Repository\CommanderRepository")
 */
class Commander
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
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $level;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $prestigeFeat;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $cha;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $soldierSkill;
    
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
    
    public function __construct()
    {
        $this->prestigeFeat = false;
        $this->level = 1;
        $this->cha = 0;
        $this->soldierSkill = 0;
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
    
    public function getLevel() {
        return $this->level;
    }

    public function getPrestigeFeat() {
        return $this->prestigeFeat;
    }

    public function getCha() {
        return $this->cha;
    }

    public function getSoldierSkill() {
        return $this->soldierSkill;
    }

    public function setLevel($level) {
        $this->level = $level;
        return $this;
    }

    public function setPrestigeFeat($prestigeFeat) {
        $this->prestigeFeat = $prestigeFeat;
        return $this;
    }

    public function setCha($cha) {
        $this->cha = $cha;
        return $this;
    }

    public function setSoldierSkill($soldierSkill) {
        $this->soldierSkill = $soldierSkill;
        return $this;
    }
    
    public function getPrestigeValue()
    {
        return 
            $this->getLevel() +
            $this->getCha() +
            $this->getPrestigeFeat() ? 3 : 0
        ;
    }
}
