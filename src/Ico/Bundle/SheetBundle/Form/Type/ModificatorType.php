<?php

namespace Ico\Bundle\SheetBundle\Form\Type;

use Ico\Bundle\RulesBundle\Entity\CharacterClass;
use Ico\Bundle\SheetBundle\Entity\Modificator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ModificatorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', null, array(
                
            ))
            ->add('value', null, array(
                
            ))
        ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Modificator::class,
        ));
    }

    public function getName()
    {
        return 'modificator';
    }
}