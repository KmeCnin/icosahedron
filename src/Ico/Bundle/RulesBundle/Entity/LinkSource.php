<?php

namespace Ico\Bundle\RulesBundle\Entity;

use Doctrine\ORM\Mapping as ORM; 
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serialize;

/**
 * LinkSource
 *
 * @ORM\Table(name="linksource", indexes={@ORM\Index(name="domain_idx", columns={"domain"})})
 * @ORM\Entity(repositoryClass="Ico\Bundle\RulesBundle\Repository\LinkSourceRepository")
 * @Serialize\XmlRoot("link_source")
 */ 
class LinkSource
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
     * @ORM\Column(name="domain", type="string", length=255)
     * @Serialize\XmlAttribute
     * @Serialize\Type("string")
     */
    private $domain;
    
    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=255)
     * @Serialize\XmlAttribute
     * @Serialize\Type("string")
     */
    private $language;
    
    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=255)
     * @Serialize\XmlAttribute
     * @Serialize\Type("string")
     */
    private $picture;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        
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
     * @return LinkSource
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
     * Set language
     *
     * @param string $language
     * @return LinkSource
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set domain
     *
     * @param string $domain
     * @return LinkSource
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return string 
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return LinkSource
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string 
     */
    public function getPicture()
    {
        return $this->picture;
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
