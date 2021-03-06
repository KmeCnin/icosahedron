<?php

namespace Ico\Bundle\RulesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serialize;

/**
 * Link
 *
 * @ORM\Table(name="link")
 * @ORM\Entity(repositoryClass="Ico\Bundle\RulesBundle\Repository\LinkRepository")
 * @Serialize\XmlRoot("link")
 */ 
class Link
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
     * @ORM\Column(name="url", type="string", length=255)
     * @Serialize\XmlAttribute
     * @Serialize\Type("string")
     * @Serialize\Groups({"token"})
     */
    private $url;
    
    /**
     * @ORM\ManyToOne(targetEntity="LinkSource", cascade={"remove", "persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Serialize\Type("Ico\Bundle\RulesBundle\Entity\LinkSource")
     * @Serialize\RecursionGroups(set={"token"})
     */
    private $source;

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
     * Set url
     *
     * @param integer $url
     * @return Link
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return integer 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set source
     *
     * @param \Ico\Bundle\RulesBundle\Entity\LinkSource $source
     * @return Link
     */
    public function setSource(\Ico\Bundle\RulesBundle\Entity\LinkSource $source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return \Ico\Bundle\RulesBundle\Entity\LinkSource 
     */
    public function getSource()
    {
        return $this->source;
    }
}
