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
     * @ORM\Column(name="type", type="string", length=50)
     */
    protected $type;
    
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
     * Set type
     *
     * @param integer $type
     *
     * @return Modificator
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param integer $type
     *
     * @return Modificator
     */
    public function setReferenceType($type)
    {
        if ($type) {
            $this->type = $type;
        }

        return $this;
    }

    /**
     * @param integer $type
     *
     * @return Modificator
     */
    public function setCustomType($type)
    {
        if ($type) {
            $this->type = $type;
        }

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return integer
     */
    public function getReferenceType()
    {
        return $this->type;
    }

    /**
     * @return integer
     */
    public function getCustomType()
    {
        return $this->type;
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
