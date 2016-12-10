<?php

namespace Ico\Bundle\AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Form\FormTypeInterface;

class BuilderAugmenter
{
    use ContainerAwareTrait;
    
    /** @var FormBuilderInterface */
    private $builder;
    
    /**
     * @param Container $container
     */
    public function __construct(Container $container) {
        $this->setContainer($container);
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @return BuilderAugmenter
     */
    public function setBuilder(FormBuilderInterface $builder) {
        $this->builder = $builder;
        return $this;
    }
    
    /**
     * @param string    $formTypeName
     * @param array     $options
     * @return BuilderAugmenter
     */
    public function add($formTypeName, array $options = [])
    {
        /** @var FormTypeInterface $formType */
        $formType = $this->container->get($formTypeName);
        $formType->buildForm($this->builder, $options);
        return $this;
    }
}