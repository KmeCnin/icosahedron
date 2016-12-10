<?php

namespace Ico\Bundle\MassFightBundle\Form\Type;

use Ico\Bundle\MassFightBundle\Entity\Army;
use Ico\Bundle\RulesBundle\Entity\Alignment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Ico\Bundle\AppBundle\Form\TypeTrait\ResponsiveFormTypeTrait;

class ArmyType extends AbstractType
{
    use ResponsiveFormTypeTrait;
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'Nom',
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'clearfix' => self::$visibilityXs,
                ],
            ))
            ->add('alignment', EntityType::class, [
                'label' => 'Alignement',
                'class' => Alignment::class,
                'choice_label' => 'name',
                'empty_data' => null,
                'required' => false,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'clearfix' => self::$visibilityXs.self::$visibilitySm,
                ],
            ])
            ->add('size', ChoiceType::class, [
                'label' => 'Taille',
                'choices' => Army::getAllSizes(),
                'choices_as_values' => false,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'clearfix' => self::$visibilityAll,
                ],
            ])
            ->add('type', null, array(
                'label' => 'Unité type',
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'clearfix' => self::$visibilityXs,
                ],
            ))
            ->add('lifeDicesType', ChoiceType::class, array(
                'label' => 'Dés de vie de l\'unité type',
                'choices' => Army::getAllDices(),
                'choices_as_values' => false,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'clearfix' => self::$visibilityXs.self::$visibilitySm,
                ],
            ))
            ->add('create', 'submit', array('label' => 'Sauvegarder'));
    }
}