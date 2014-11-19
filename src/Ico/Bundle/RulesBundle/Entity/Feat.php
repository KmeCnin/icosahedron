<?php

namespace Ico\Bundle\RulesBundle\Entity;

use Doctrine\ORM\Mapping as ORM; 
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Feat
 *
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="feat", indexes={@ORM\Index(name="nameId_idx", columns={"nameId"})})
 * @ORM\Entity(repositoryClass="Ico\Bundle\RulesBundle\Repository\FeatRepository")
 */ 
class Feat
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
     * @Gedmo\Slug(fields={"nameId"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @ORM\ManyToMany(targetEntity="Link", cascade={"remove", "persist"})
     */
    protected $links;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="benefit", type="text")
     */
    private $benefit;
    
    /**
     * @var ArrayCollection FeatType $featTypes
     * Owning Side
     *
     * @ORM\ManyToMany(targetEntity="FeatType", inversedBy="feats", cascade={"persist", "merge", "remove"})
     * @ORM\JoinTable(joinColumns={@ORM\JoinColumn(onDelete="CASCADE")}, inverseJoinColumns={@ORM\JoinColumn(onDelete="CASCADE")})
     */
    protected $featTypes;
    
    /**
     * @ORM\OneToMany(targetEntity="FeatPrerequisite", mappedBy="feat", cascade={"persist"})
     */
    protected $featPrerequisites;
    
    /****** Tree DoctrineExtension *******/
    
    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Feat", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Feat", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        
        $this->featTypes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Feat
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
     * @return Feat
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
     * Set description
     *
     * @param string $description
     * @return Feat
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
     * Set benefit
     *
     * @param string $benefit
     * @return Feat
     */
    public function setBenefit($benefit)
    {
        $this->benefit = $benefit;

        return $this;
    }

    /**
     * Get benefit
     *
     * @return string 
     */
    public function getBenefit()
    {
        return $this->benefit;
    }

    /**
     * Add links
     *
     * @param \Ico\Bundle\RulesBundle\Entity\Link $links
     * @return Feat
     */
    public function addLink(\Ico\Bundle\RulesBundle\Entity\Link $links)
    {
        $this->links[] = $links;

        return $this;
    }

    /**
     * Remove links
     *
     * @param \Ico\Bundle\RulesBundle\Entity\Link $links
     */
    public function removeLink(\Ico\Bundle\RulesBundle\Entity\Link $links)
    {
        $this->links->removeElement($links);
    }

    /**
     * Get links
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Add featTypes
     *
     * @param \Ico\Bundle\RulesBundle\Entity\FeatType $featTypes
     * @return Feat
     */
    public function addFeatType(\Ico\Bundle\RulesBundle\Entity\FeatType $featTypes)
    {
        $this->featTypes[] = $featTypes;

        return $this;
    }

    /**
     * Remove featTypes
     *
     * @param \Ico\Bundle\RulesBundle\Entity\FeatType $featTypes
     */
    public function removeFeatType(\Ico\Bundle\RulesBundle\Entity\FeatType $featTypes)
    {
        $this->featTypes->removeElement($featTypes);
    }

    /**
     * Get featTypes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFeatTypes()
    {
        return $this->featTypes;
    }

    /**
     * Add featPrerequisites
     *
     * @param \Ico\Bundle\RulesBundle\Entity\FeatPrerequisite $featPrerequisites
     * @return Feat
     */
    public function addFeatPrerequisite(\Ico\Bundle\RulesBundle\Entity\FeatPrerequisite $featPrerequisites)
    {
        $this->featPrerequisites[] = $featPrerequisites;

        return $this;
    }

    /**
     * Remove featPrerequisites
     *
     * @param \Ico\Bundle\RulesBundle\Entity\FeatPrerequisite $featPrerequisites
     */
    public function removeFeatPrerequisite(\Ico\Bundle\RulesBundle\Entity\FeatPrerequisite $featPrerequisites)
    {
        $this->featPrerequisites->removeElement($featPrerequisites);
    }

    /**
     * Get featPrerequisites
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFeatPrerequisites()
    {
        return $this->featPrerequisites;
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

    /**
     * Set lft
     *
     * @param integer $lft
     * @return Feat
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get lft
     *
     * @return integer 
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set lvl
     *
     * @param integer $lvl
     * @return Feat
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer 
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     * @return Feat
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * Get rgt
     *
     * @return integer 
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set root
     *
     * @param integer $root
     * @return Feat
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root
     *
     * @return integer 
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set parent
     *
     * @param \Ico\Bundle\RulesBundle\Entity\Feat $parent
     * @return Feat
     */
    public function setParent(\Ico\Bundle\RulesBundle\Entity\Feat $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Ico\Bundle\RulesBundle\Entity\Feat 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param \Ico\Bundle\RulesBundle\Entity\Feat $children
     * @return Feat
     */
    public function addChild(\Ico\Bundle\RulesBundle\Entity\Feat $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Ico\Bundle\RulesBundle\Entity\Feat $children
     */
    public function removeChild(\Ico\Bundle\RulesBundle\Entity\Feat $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }
}
