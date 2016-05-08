<?php

namespace Ico\Bundle\SheetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations

/**
 * Sheet
 *
 * @ORM\Table(name="sheet")
 * @ORM\Entity(repositoryClass="Ico\Bundle\SheetBundle\Repository\SheetRepository")
 */
class Sheet
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
     * @ORM\Column(name="characterName", type="string", length=255)
     */
    private $characterName;
    
    /**
     * @Gedmo\Slug(fields={"characterName"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var ArrayCollection[ClassLevel]
     *
     * @ORM\ManyToMany(targetEntity="ClassLevel", cascade={"persist", "merge", "remove"})
     */
    private $classLevels;
    
    /**
     * @var string
     *
     * @ORM\Column(name="race", type="string", length=255)
     */
    private $customRace;
    
    /**
     * @var SizeCategory
     *
     * @ORM\ManyToOne(targetEntity="Ico\Bundle\RulesBundle\Entity\SizeCategory")
     */
    private $sizeCategory;
    
    /**
     * @ORM\ManyToOne(targetEntity="\Ico\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

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
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->classLevels = new \Doctrine\Common\Collections\ArrayCollection();
        $this->classLevels->add(new ClassLevel());
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
     * Set characterName
     *
     * @param string $name
     * @return Campaign
     */
    public function setCharacterName($name)
    {
        $this->characterName = $name;

        return $this;
    }

    /**
     * Get characterName
     *
     * @return string 
     */
    public function getCharacterName()
    {
        return $this->characterName;
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

    /**
     * Add classLevels
     *
     * @param \Ico\Bundle\SheetBundle\Entity\ClassLevel $classLevels
     * @return Sheet
     */
    public function addClassLevel(\Ico\Bundle\SheetBundle\Entity\ClassLevel $classLevels)
    {
        $this->classLevels[] = $classLevels;

        return $this;
    }

    /**
     * Remove classLevels
     *
     * @param \Ico\Bundle\SheetBundle\Entity\ClassLevel $classLevels
     */
    public function removeClassLevel(\Ico\Bundle\SheetBundle\Entity\ClassLevel $classLevels)
    {
        $this->classLevels->removeElement($classLevels);
    }

    /**
     * Get classLevels
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClassLevels()
    {
        return $this->classLevels;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return User
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return User
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
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
    public function setCreatedBy(\Ico\Bundle\UserBundle\Entity\User $createdBy)
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
     * Set customRace
     *
     * @param string $customRace
     *
     * @return Sheet
     */
    public function setCustomRace($customRace)
    {
        $this->customRace = $customRace;

        return $this;
    }

    /**
     * Get customRace
     *
     * @return string
     */
    public function getCustomRace()
    {
        return $this->customRace;
    }

    /**
     * Set sizeCategory
     *
     * @param \Ico\Bundle\RulesBundle\Entity\SizeCategory $sizeCategory
     *
     * @return Sheet
     */
    public function setSizeCategory(\Ico\Bundle\RulesBundle\Entity\SizeCategory $sizeCategory = null)
    {
        $this->sizeCategory = $sizeCategory;

        return $this;
    }

    /**
     * Get sizeCategory
     *
     * @return \Ico\Bundle\RulesBundle\Entity\SizeCategory
     */
    public function getSizeCategory()
    {
        return $this->sizeCategory;
    }
}
