<?php

namespace Ico\Bundle\SheetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Calculation
 *
 * @ORM\Table(name="calculation")
 * @ORM\Entity(repositoryClass="Ico\Bundle\SheetBundle\Repository\CalculationRepository")
 */
class Calculation
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
     * @var ArrayCollection[Modificator]
     *
     * @ORM\ManyToMany(targetEntity="Modificator", cascade={"persist", "merge", "remove"})
     * @Assert\Valid
     */
    protected $modificators;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->modificators = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add modificator
     *
     * @param \Ico\Bundle\SheetBundle\Entity\Modificator $modificator
     *
     * @return Calculation
     */
    public function addModificator(\Ico\Bundle\SheetBundle\Entity\Modificator $modificator)
    {
        $this->modificators[] = $modificator;

        return $this;
    }

    /**
     * Remove modificator
     *
     * @param \Ico\Bundle\SheetBundle\Entity\Modificator $modificator
     */
    public function removeModificator(\Ico\Bundle\SheetBundle\Entity\Modificator $modificator)
    {
        $this->modificators->removeElement($modificator);
    }

    /**
     * Get modificators
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModificators()
    {
        return $this->modificators;
    }
}
