<?php

namespace Ico\Bundle\SheetBundle\Form\Type;

use Ico\Bundle\RulesBundle\Entity\CharacterClass;
use Ico\Bundle\SheetBundle\Entity\Modificator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ModificatorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('referenceType', ChoiceType::class, array(
                'label' => 'Type',
                'choices'  => $options['referenceTypes'],
                'attr' => [
                    'data-switch' => 'reference',
                    'placeholder' => 'Type personnalisé',
                ],
                'error_bubbling' => false,
                'choices_as_values' => true,
                'by_reference' => true,
            ))
            ->add('customType', null, array(
                'label' => 'Type',
                'attr' => [
                    'data-switch' => 'custom',
                    'placeholder' => 'Type personnalisé',
                ],
                'error_bubbling' => false,
                'by_reference' => true,
            ))
            ->add('value', null, array())
        ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Modificator::class,
            'referenceTypes' => [
                'Base' => 'Base',
            ],
        ));
    }

    public function getName()
    {
        return 'modificator';
    }
}