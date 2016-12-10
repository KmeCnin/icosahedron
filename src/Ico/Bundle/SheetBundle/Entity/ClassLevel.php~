<?php

namespace Ico\Bundle\SheetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ClassLevel
 *
 * @ORM\Table(name="class_level", indexes={@ORM\Index(name="level_idx", columns={"level"})})
 * @ORM\Entity(repositoryClass="Ico\Bundle\SheetBundle\Repository\ClassLevelRepository")
 */
class ClassLevel
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
     * @ORM\Column(name="level", type="integer")
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(value=1)
     */
    private $level;
    
    /**
     * @var CharacterClass 
     * 
     * @ORM\ManyToOne(targetEntity="Ico\Bundle\RulesBundle\Entity\CharacterClass", cascade={"remove", "persist"})
     */
    private $referenceCharacterClass;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="customCharacterClass", type="string", length=255, nullable=true)
     */
    private $customCharacterClass;

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
     * Set level
     *
     * @param integer $level
     * @return CharacterClassLevel
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }
    
    /**
     * Set customCharacterClass
     *
     * @param string $customCharacterClass
     * @return ClassLevel
     */
    public function setCustomCharacterClass($customCharacterClass)
    {
        $this->customCharacterClass = $customCharacterClass;

        return $this;
    }

    /**
     * Get customCharacterClass
     *
     * @return string 
     */
    public function getCustomCharacterClass()
    {
        return $this->customCharacterClass;
    }

    /**
     * Set referenceCharacterClass
     *
     * @param \Ico\Bundle\RulesBundle\Entity\CharacterClass $referenceCharacterClass
     *
     * @return ClassLevel
     */
    public function setReferenceCharacterClass(\Ico\Bundle\RulesBundle\Entity\CharacterClass $referenceCharacterClass = null)
    {
        $this->referenceCharacterClass = $referenceCharacterClass;

        return $this;
    }

    /**
     * Get referenceCharacterClass
     *
     * @return \Ico\Bundle\RulesBundle\Entity\CharacterClass
     */
    public function getReferenceCharacterClass()
    {
        return $this->referenceCharacterClass;
    }
}
