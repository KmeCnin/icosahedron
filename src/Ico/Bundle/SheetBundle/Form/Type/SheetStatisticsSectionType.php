<?php

namespace Ico\Bundle\SheetBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Ico\Bundle\AppBundle\Form\AbstractSectionType;
use Ico\Bundle\AppBundle\Form\TypeTrait\ResponsiveFormTypeTrait;
use Ico\Bundle\RulesBundle\Entity\Gender;
use Ico\Bundle\RulesBundle\Entity\SizeCategory;
use Ico\Bundle\SheetBundle\Entity\Modificator;
use Ico\Bundle\SheetBundle\Entity\Sheet;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SheetStatisticsSectionType extends AbstractSectionType
{
    use ResponsiveFormTypeTrait;
    
    /** @var EntityManager */
    private $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    protected function getDisplayName()
    {
        return 'Statistiques';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $referenceTypesAbilities = [
            'Base' => 'Base',
            'Race' => 'Race',
            'Altération' => 'Altération',
        ];
        $referenceTypesSavingThrows = [
            'Base' => 'Base',
            'Magie' => 'Magie',
            'Divers' => 'Divers',
        ];
        $this->setBuilder($builder)
            ->add('strengthAbility', 'collection_prototype', array(
                'label' => 'Force',
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'type' => 'modificator',
                'prototype' => true,
                'by_reference' => false,
                'unique_fields' => ['type'],
                'auto_calculated_total' => 'default',
                'auto_calculated_total' => 'ability',
                'min_entries' => 2,
                'max_entries' => 10,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                ],
                'options' => [
                    'referenceTypes' => $referenceTypesAbilities,
                ]
            ))
            ->add('dexterityAbility', 'collection_prototype', array(
                'label' => 'Dexterité',
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'type' => 'modificator',
                'prototype' => true,
                'by_reference' => false,
                'unique_fields' => ['type'],
                'auto_calculated_total' => 'default',
                'auto_calculated_total' => 'ability',
                'min_entries' => 2,
                'max_entries' => 10,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'clearfix' => self::$visibilitySm,
                ],
                'options' => [
                    'referenceTypes' => $referenceTypesAbilities,
                ]
            ))
            ->add('constitutionAbility', 'collection_prototype', array(
                'label' => 'Constitution',
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'type' => 'modificator',
                'prototype' => true,
                'by_reference' => false,
                'unique_fields' => ['type'],
                'auto_calculated_total' => 'default',
                'auto_calculated_total' => 'ability',
                'min_entries' => 2,
                'max_entries' => 10,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'clearfix' => self::$visibilityMd.self::$visibilityLg,
                ],
                'options' => [
                    'referenceTypes' => $referenceTypesAbilities,
                ]
            ))
            ->add('intelligenceAbility', 'collection_prototype', array(
                'label' => 'Intelligence',
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'type' => 'modificator',
                'prototype' => true,
                'by_reference' => false,
                'unique_fields' => ['type'],
                'auto_calculated_total' => 'default',
                'auto_calculated_total' => 'ability',
                'min_entries' => 2,
                'max_entries' => 10,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'clearfix' => self::$visibilitySm,
                ],
                'options' => [
                    'referenceTypes' => $referenceTypesAbilities,
                ]
            ))
            ->add('wisdomAbility', 'collection_prototype', array(
                'label' => 'Sagesse',
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'type' => 'modificator',
                'prototype' => true,
                'by_reference' => false,
                'unique_fields' => ['type'],
                'auto_calculated_total' => 'default',
                'auto_calculated_total' => 'ability',
                'min_entries' => 2,
                'max_entries' => 10,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                ],
                'options' => [
                    'referenceTypes' => $referenceTypesAbilities,
                ]
            ))
            ->add('charismaAbility', 'collection_prototype', array(
                'label' => 'Charisme',
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'type' => 'modificator',
                'prototype' => true,
                'by_reference' => false,
                'unique_fields' => ['type'],
                'auto_calculated_total' => 'default',
                'auto_calculated_total' => 'ability',
                'min_entries' => 2,
                'max_entries' => 10,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'clearfix' => self::$visibilitySm.self::$visibilityMd.self::$visibilityLg,
                ],
                'options' => [
                    'referenceTypes' => $referenceTypesAbilities,
                ]
            ))
            ->add('reflex', 'collection_prototype', array(
                'label' => 'Réflexes',
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'type' => 'modificator',
                'prototype' => true,
                'by_reference' => false,
                'unique_fields' => ['type'],
                'auto_calculated_total' => 'default',
                'auto_calculated_fields' => [
                    'dexterityAbility' => 'mod',
                ],
                'min_entries' => 3,
                'max_entries' => 20,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                ],
                'options' => [
                    'referenceTypes' => $referenceTypesSavingThrows,
                ]
            ))
            ->add('fortitude', 'collection_prototype', array(
                'label' => 'Vigueur',
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'type' => 'modificator',
                'prototype' => true,
                'by_reference' => false,
                'unique_fields' => ['type'],
                'auto_calculated_total' => 'default',
                'auto_calculated_fields' => [
                    'constitutionAbility' => 'mod',
                ],
                'min_entries' => 3,
                'max_entries' => 20,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'clearfix' => self::$visibilitySm,
                ],
                'options' => [
                    'referenceTypes' => $referenceTypesSavingThrows,
                ]
            ))
            ->add('will', 'collection_prototype', array(
                'label' => 'Volonté',
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'type' => 'modificator',
                'prototype' => true,
                'by_reference' => false,
                'unique_fields' => ['type'],
                'auto_calculated_total' => 'default',
                'auto_calculated_fields' => [
                    'wisdomAbility' => 'mod',
                ],
                'min_entries' => 3,
                'max_entries' => 20,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'clearfix' => self::$visibilitySm.self::$visibilityMd.self::$visibilityLg,
                ],
                'options' => [
                    'referenceTypes' => $referenceTypesSavingThrows,
                ]
            ))
            ->add('acidResistance', null, array(
                'label' => 'Résistance à l\'acide',
                'attr' => [
                    'formGroupClass' => self::$inputExtraSmall,
                ],
            ))
            ->add('fireResistance', null, array(
                'label' => 'Résistance au feu',
                'attr' => [
                    'formGroupClass' => self::$inputExtraSmall,
                ],
            ))
            ->add('lighteningResistance', null, array(
                'label' => 'Résistance à la foudre',
                'attr' => [
                    'formGroupClass' => self::$inputExtraSmall,
                ],
            ))
            ->add('coldResistance', null, array(
                'label' => 'Résistance au froid',
                'attr' => [
                    'formGroupClass' => self::$inputExtraSmall,
                ],
            ))
            ->add('sonicResistance', null, array(
                'label' => 'Résistance au son',
                'attr' => [
                    'formGroupClass' => self::$inputExtraSmall,
                ],
            ))
            ->add('spellResistance', null, array(
                'label' => 'Résistance à la magie',
                'attr' => [
                    'formGroupClass' => self::$inputExtraSmall,
                ],
            ))
        ;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Sheet::class,
        ));
    }

    public function getName()
    {
        return 'sheet_statistics_section';
    }
}