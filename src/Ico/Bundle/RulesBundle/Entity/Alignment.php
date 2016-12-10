<?php

namespace Ico\Bundle\RulesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serialize;

/**
 * Alignment
 *
 * @ORM\Table(name="alignment")
 * @ORM\Entity(repositoryClass="Ico\Bundle\RulesBundle\Repository\AlignmentRepository")
 * @Serialize\XmlRoot("alignment")
 */
class Alignment
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
     * @ORM\Column(name="short", type="string", length=3)
     * @Serialize\XmlAttribute
     * @Serialize\Type("string")
     */
    private $short;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $detail;
    
    /**
     * @ORM\ManyToOne(targetEntity="Link", cascade={"remove", "persist"})
     * @Serialize\Type("Ico\Bundle\RulesBundle\Entity\Link")
     */
    protected $link;
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function getShort() {
        return $this->short;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getLink() {
        return $this->link;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
        return $this;
    }

    public function setShort($short) {
        $this->short = $short;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setLink($link) {
        $this->link = $link;
        return $this;
    }
    
    public function getDetail() {
        return $this->detail;
    }

    public function setDetail($detail) {
        $this->detail = $detail;
        return $this;
    }
}
