<?php

namespace Ico\Bundle\RulesBundle\Entity;

use Doctrine\ORM\Mapping as ORM; 
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serialize;

/**
 * FeatPrerequisite
 *
 * @ORM\Table(name="featprerequisite")
 * @ORM\Entity(repositoryClass="Ico\Bundle\RulesBundle\Repository\FeatPrerequisiteRepository")
 * @Serialize\XmlRoot("feat_prerequisite")
 */ 
class FeatPrerequisite
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serialize\XmlAttribute
     * @Serialize\Type("integer")
     * @Serialize\Groups({"token"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Serialize\XmlAttribute
     * @Serialize\Type("string")
     * @Serialize\Groups({"token"})
     */
    private $name;
    
    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255)
     * @Serialize\XmlAttribute
     * @Serialize\Type("string")
     * @Serialize\Groups({"token"})
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255)
     * @Serialize\XmlAttribute
     * @Serialize\Type("string")
     */
    private $link;
    
    /**
     * @ORM\ManyToOne(targetEntity="Feat", cascade={"remove"}, inversedBy="featPrerequisites")
     * @ORM\JoinColumn(nullable=false)
     * @Serialize\Type("Ico\Bundle\RulesBundle\Entity\Feat")
     * @Serialize\RecursionGroups(set={"token"})
     */
    private $feat;
    
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
     * Set name
     *
     * @param string $name
     * @return FeatPrerequisite
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
     * Set link
     *
     * @param string $link
     * @return FeatPrerequisite
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set feat
     *
     * @param \Ico\Bundle\RulesBundle\Entity\Feat $feat
     * @return FeatPrerequisite
     */
    public function setFeat(\Ico\Bundle\RulesBundle\Entity\Feat $feat)
    {
        $this->feat = $feat;

        return $this;
    }

    /**
     * Get feat
     *
     * @return \Ico\Bundle\RulesBundle\Entity\Feat 
     */
    public function getFeat()
    {
        return $this->feat;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return BattleRange
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
}
