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
     * @var text
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
    /**
     * @ORM\ManyToOne(targetEntity="Link", cascade={"remove", "persist"})
     * @Serialize\Type("Ico\Bundle\RulesBundle\Entity\Link")
     */
    protected $link;

}
