<?php

namespace Ico\Bundle\RulesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Feat
 *
 * @ORM\Table()
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="wiki", type="string", length=255)
     */
    private $wiki;

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
     * Set wiki
     *
     * @param string $wiki
     * @return Feat
     */
    public function setWiki($wiki)
    {
        $this->wiki = $wiki;

        return $this;
    }

    /**
     * Get wiki
     *
     * @return string 
     */
    public function getWiki()
    {
        return $this->wiki;
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
}
