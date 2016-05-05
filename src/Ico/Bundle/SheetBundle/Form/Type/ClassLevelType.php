<?php

namespace Ico\Bundle\SheetBundle\Form\Type;

use Ico\Bundle\SheetBundle\Entity\ClassLevel;
use Ico\Bundle\RulesBundle\Entity\CharacterClass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClassLevelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('characterClass', 'entity', array(
                'label' => 'Classe',
                'class' => CharacterClass::class,
                'property' => 'name',
            ))
            ->add('customCharacterClass', null, array('label' => 'Classe'))
            ->add('level', null, array('label' => 'Niveau'))
        ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ClassLevel::class,
        ));
    }

    public function getName()
    {
        return 'classLevel';
    }
}