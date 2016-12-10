<?php

namespace Ico\Bundle\SheetBundle\Form\Type;

use Ico\Bundle\RulesBundle\Entity\CharacterClass;
use Ico\Bundle\SheetBundle\Entity\ClassLevel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClassLevelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('referenceCharacterClass', 'entity', array(
                'label' => 'Classe',
                'class' => CharacterClass::class,
                'property' => 'name',
                'required' => false,
                'attr' => [
                    'data-switch' => 'reference',
                ],
                'error_bubbling' => false,
            ))
            ->add('customCharacterClass', null, array(
                'label' => 'Classe',
                'attr' => [
                    'data-switch' => 'custom',
                    'placeholder' => 'Classe personnalisée',
                ],
                'error_bubbling' => false,
            ))
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
        return 'class_level';
    }
}