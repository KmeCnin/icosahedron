<?php

namespace Ico\Bundle\SheetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Modificator
 *
 * @ORM\Table(name="modificator")
 * @ORM\Entity(repositoryClass="Ico\Bundle\SheetBundle\Repository\ModificatorRepository")
 */
class Modificator
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="referenceType", type="string", length=50)
     */
    protected $referenceType;
    
    /**
     * @var string
     *
     * @ORM\Column(name="customType", type="string", length=50)
     */
    protected $customType;
    
    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer")
     */
    protected $value;
    
    public function __construct() {
        $this->setValue(0);
    }

    /**
     * @return Modificator
     */
    public function create()
    {
        return new Modificator();
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
     * @param integer $type
     *
     * @return Modificator
     */
    public function setReferenceType($type)
    {
        $this->referenceType = $type;

        return $this;
    }

    /**
     * @param integer $type
     *
     * @return Modificator
     */
    public function setCustomType($type)
    {
        $this->customType = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getReferenceType()
    {
        return $this->referenceType;
    }

    /**
     * @return string
     */
    public function getCustomType()
    {
        return $this->customType;
    }

    /**
     * Set value
     *
     * @param integer $value
     *
     * @return Modificator
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }
}
