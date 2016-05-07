<?php

namespace Ico\Bundle\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CollectionPrototypeType extends AbstractType
{    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAttribute('unique_fields', $options['unique_fields'])
            ->setAttribute('min_entries', $options['min_entries'])
            ->setAttribute('max_entries', $options['max_entries'])
        ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'unique_fields' => [],
            'min_entries' => 0,
            'max_entries' => 50,
        ));
    }
    
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['unique_fields'] = $options['unique_fields'];
        $view->vars['min_entries'] = $options['min_entries'];
        $view->vars['max_entries'] = $options['max_entries'];
    }
    
    public function getParent()
    {
        return 'collection';
    }

    public function getName()
    {
        return 'collection_prototype';
    }
}