<?php

namespace Ico\Bundle\MassFightBundle\Form\Type;

use Ico\Bundle\AppBundle\Form\TypeTrait\ResponsiveFormTypeTrait;
use Ico\Bundle\MassFightBundle\Entity\Benefit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class CommanderType extends AbstractType
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
            ->add('level', IntegerType::class, array(
                'label' => 'Niveau',
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'clearfix' => self::$visibilityXs.self::$visibilitySm,
                ],
            ))
            ->add('prestigeFeat', CheckboxType::class, array(
                'label' => 'Prestige',
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'clearfix' => self::$visibilityXs.self::$visibilityMd,
                ],
            ))
            ->add('cha', IntegerType::class, array(
                'label' => 'Modificateur de charisme',
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'clearfix' => self::$visibilityXs.self::$visibilitySm,
                ],
            ))
            ->add('soldierSkill', IntegerType::class, array(
                'label' => 'Rangs en Profession (soldat)',
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'clearfix' => self::$visibilityAll,
                ],
            ))
            ->add('benefits', EntityType::class, array(
                'label' => 'Bienfaits',
                'class' => Benefit::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => true,
                'attr' => [
                    'formGroupClass' => self::$inputLarge,
                ],
            ))
        ;
    }
}