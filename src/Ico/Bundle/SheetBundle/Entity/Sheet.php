<?php

namespace Ico\Bundle\SheetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Valid
     */
    private $classLevels;
    
    /**
     * @var string
     *
     * @ORM\Column(name="customRace", type="string", length=255)
     */
    private $customRace;
    
    /**
     * @var SizeCategory
     *
     * @ORM\ManyToOne(targetEntity="Ico\Bundle\RulesBundle\Entity\SizeCategory")
     */
    private $sizeCategory;
    
    /**
     * @var Gender
     *
     * @ORM\ManyToOne(targetEntity="Ico\Bundle\RulesBundle\Entity\Gender")
     */
    private $gender;
    
    /**
     * @var string
     *
     * @ORM\Column(name="customReligion", type="string", length=255)
     */
    private $customReligion;
    
    /**
     * @var string
     *
     * @ORM\Column(name="customHomeland", type="string", length=255)
     */
    private $customHomeland;
    
    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;
    
    /**
     * @var int $weight in kg
     *
     * @ORM\Column(name="weight", type="integer")
     * @Assert\GreaterThanOrEqual(value=0)
     */
    private $weight;
    
    /**
     * @var int $height in cm
     *
     * @ORM\Column(name="height", type="integer")
     * @Assert\GreaterThanOrEqual(value=0)
     */
    private $height;
    
    /**
     * @var string
     *
     * @ORM\Column(name="eyes", type="string", length=100)
     */
    private $eyes;
    
    /**
     * @var string
     *
     * @ORM\Column(name="hair", type="string", length=100)
     */
    private $hair;
    
    /**
     * @var string
     *
     * @ORM\Column(name="skin", type="string", length=100)
     */
    private $skin;
    
    /**
     * @var string
     *
     * @ORM\Column(name="hand", type="string", length=100)
     */
    private $hand;
    
    /**
     * @var Calculation
     * 
	* @ORM\OneToOne(targetEntity="Calculation", cascade={"persist", "remove"})
	*/
    private $forceAbility;
    
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

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return Sheet
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set customReligion
     *
     * @param string $customReligion
     *
     * @return Sheet
     */
    public function setCustomReligion($customReligion)
    {
        $this->customReligion = $customReligion;

        return $this;
    }

    /**
     * Get customReligion
     *
     * @return string
     */
    public function getCustomReligion()
    {
        return $this->customReligion;
    }

    /**
     * Set customHomeland
     *
     * @param string $customHomeland
     *
     * @return Sheet
     */
    public function setCustomHomeland($customHomeland)
    {
        $this->customHomeland = $customHomeland;

        return $this;
    }

    /**
     * Get customHomeland
     *
     * @return string
     */
    public function getCustomHomeland()
    {
        return $this->customHomeland;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return Sheet
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     *
     * @return Sheet
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set height
     *
     * @param integer $height
     *
     * @return Sheet
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set eyes
     *
     * @param string $eyes
     *
     * @return Sheet
     */
    public function setEyes($eyes)
    {
        $this->eyes = $eyes;

        return $this;
    }

    /**
     * Get eyes
     *
     * @return string
     */
    public function getEyes()
    {
        return $this->eyes;
    }

    /**
     * Set hair
     *
     * @param string $hair
     *
     * @return Sheet
     */
    public function setHair($hair)
    {
        $this->hair = $hair;

        return $this;
    }

    /**
     * Get hair
     *
     * @return string
     */
    public function getHair()
    {
        return $this->hair;
    }

    /**
     * Set hand
     *
     * @param string $hand
     *
     * @return Sheet
     */
    public function setHand($hand)
    {
        $this->hand = $hand;

        return $this;
    }

    /**
     * Get hand
     *
     * @return string
     */
    public function getHand()
    {
        return $this->hand;
    }

    /**
     * Set skin
     *
     * @param string $skin
     *
     * @return Sheet
     */
    public function setSkin($skin)
    {
        $this->skin = $skin;

        return $this;
    }

    /**
     * Get skin
     *
     * @return string
     */
    public function getSkin()
    {
        return $this->skin;
    }

    /**
     * Set forceAbility
     *
     * @param \Ico\Bundle\SheetBundle\Entity\Calculation $forceAbility
     *
     * @return Sheet
     */
    public function setForceAbility(\Ico\Bundle\SheetBundle\Entity\Calculation $forceAbility = null)
    {
        $this->forceAbility = $forceAbility;

        return $this;
    }

    /**
     * Get forceAbility
     *
     * @return \Ico\Bundle\SheetBundle\Entity\Calculation
     */
    public function getForceAbility()
    {
        return $this->forceAbility;
    }
}
