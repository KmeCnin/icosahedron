<?php

namespace Ico\Bundle\RulesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * SizeCategory
 *
 * @ORM\Table(name="size_category")
 * @ORM\Entity(repositoryClass="Ico\Bundle\RulesBundle\Repository\SizeCategoryRepository")
 */
class SizeCategory
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
     * @var string
     *
     * @ORM\Column(name="short", type="string", length=3)
     */
    private $short;
    
    /**
     * @var string
     *
     * @ORM\Column(name="defaultSpace", type="string", length=20)
     */
    private $defaultSpace;
    
    /**
     * @var string
     *
     * @ORM\Column(name="defaultReachHorizontal", type="string", length=20)
     */
    private $defaultReachHorizontal;
    
    /**
     * @var string
     *
     * @ORM\Column(name="defaultReachVertical", type="string", length=20)
     */
    private $defaultReachVertical;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

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
     *
     * @return SizeCategory
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
     * Set slug
     *
     * @param string $slug
     *
     * @return SizeCategory
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
     * Set short
     *
     * @param string $short
     *
     * @return SizeCategory
     */
    public function setShort($short)
    {
        $this->short = $short;

        return $this;
    }

    /**
     * Get short
     *
     * @return string
     */
    public function getShort()
    {
        return $this->short;
    }

    /**
     * Set defaultSpace
     *
     * @param string $defaultSpace
     *
     * @return SizeCategory
     */
    public function setDefaultSpace($defaultSpace)
    {
        $this->defaultSpace = $defaultSpace;

        return $this;
    }

    /**
     * Get defaultSpace
     *
     * @return string
     */
    public function getDefaultSpace()
    {
        return $this->defaultSpace;
    }

    /**
     * Set defaultReachHorizontal
     *
     * @param string $defaultReachHorizontal
     *
     * @return SizeCategory
     */
    public function setDefaultReachHorizontal($defaultReachHorizontal)
    {
        $this->defaultReachHorizontal = $defaultReachHorizontal;

        return $this;
    }

    /**
     * Get defaultReachHorizontal
     *
     * @return string
     */
    public function getDefaultReachHorizontal()
    {
        return $this->defaultReachHorizontal;
    }

    /**
     * Set defaultReachVertical
     *
     * @param string $defaultReachVertical
     *
     * @return SizeCategory
     */
    public function setDefaultReachVertical($defaultReachVertical)
    {
        $this->defaultReachVertical = $defaultReachVertical;

        return $this;
    }

    /**
     * Get defaultReachVertical
     *
     * @return string
     */
    public function getDefaultReachVertical()
    {
        return $this->defaultReachVertical;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return SizeCategory
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
}
