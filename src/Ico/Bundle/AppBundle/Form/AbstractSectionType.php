<?php

namespace Ico\Bundle\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AbstractSectionType extends AbstractType
{
    /** @var FormBuilderInterface */
    protected $builder;
    
    /**
     * @param FormBuilderInterface $builder
     * @return AbstractSectionType
     */
    protected function setBuilder(FormBuilderInterface $builder)
    {
        $this->builder = $builder;
        return $this;
    }
    
    /**
     * @param string|int|FormBuilderInterface $child
     * @param string|FormTypeInterface        $type
     * @param array                           $options
     *
     * @return AbstractSectionType
     */
    protected function add($child, $type = null, array $options = [])
    {
        $this->builder->add($child, $type, array_merge_recursive (
            ['attr' => ['data-section' => $this->getName()]],
            $options
        ));
        return $this;
    }
}
