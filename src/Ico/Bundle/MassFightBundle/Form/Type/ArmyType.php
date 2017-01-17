<?php

namespace Ico\Bundle\MassFightBundle\Form\Type;

use Ico\Bundle\AppBundle\Entity\Campaign;
use Ico\Bundle\AppBundle\Form\TypeTrait\ResponsiveFormTypeTrait;
use Ico\Bundle\MassFightBundle\Entity\Army;
use Ico\Bundle\MassFightBundle\Entity\Commander;
use Ico\Bundle\MassFightBundle\Entity\Tactic;
use Ico\Bundle\RulesBundle\Entity\Alignment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

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
                    'formGroupClass' => self::$inputExtraSmall,
                    'clearfix' => self::$visibilityXs.self::$visibilitySm,
                ],
            ])
            ->add('size', null, [
                'label' => 'Nombre d\'unités',
                'attr' => [
                    'formGroupClass' => self::$inputExtraSmall,
                    'clearfix' => self::$visibilityXs.self::$visibilityMd,
                ],
            ])
            ->add('campaign', EntityType::class, [
                'label' => 'Campagne',
                'class' => Campaign::class,
                'choice_label' => 'name',
                'empty_data' => null,
                'required' => false,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'clearfix' => self::$visibilityXs.self::$visibilitySm,
                ],
            ])
            ->add('type', null, array(
                'label' => 'Profil (classe, race, niveau...)',
                'attr' => [
                    'formGroupClass' => self::$inputDefault,
                    'clearfix' => self::$visibilityXs.self::$visibilitySm.self::$visibilityMd,
                ],
            ))
            ->add('lifeDicesType', ChoiceType::class, array(
                'label' => 'Dés de vie',
                'choices' => Army::getAllDices(),
                'choices_as_values' => false,
                'attr' => [
                    'formGroupClass' => self::$inputExtraSmall,
                    'clearfix' => self::$visibilityXs,
                ],
            ))
            ->add('fpType', ChoiceType::class, array(
                'label' => 'FP',
                'choices' => Army::getAllFpTypes(),
                'choices_as_values' => false,
                'attr' => [
                    'formGroupClass' => self::$inputExtraSmall,
                    'clearfix' => self::$visibilityXs,
                ],
            ))
            ->add('speed', null, [
                'label' => 'Déplacement (cases)',
                'attr' => [
                    'formGroupClass' => self::$inputExtraSmall,
                ],
            ])
            ->add('tactics', EntityType::class, [
                'label' => 'Tactiques connues',
                'class' => Tactic::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => true,
                'attr' => [
                    'formGroupClass' => self::$inputLarge,
                ],
            ])
            ->add('commander', EntityType::class, [
                'label' => 'Commandant',
                'class' => Commander::class,
                'choice_label' => 'name',
                'placeholder' => 'Créer un nouveau',
                'required' => false,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                ],
            ])
            ->add('newCommander', CommanderType::class, [
                'mapped' => false,
                'data_class' => Commander::class,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'clearfix' => self::$visibilityAll,
                ],
            ])
        ;
    }
}