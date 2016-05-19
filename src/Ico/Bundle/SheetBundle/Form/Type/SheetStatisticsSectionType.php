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
        $referenceTypes = [
            'Base' => 'Base',
            'Race' => 'Race',
            'Altération' => 'Altération',
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
                'min_entries' => 1,
                'max_entries' => 10,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'data-display-sum' => 'ability',
                ],
                'options' => [
                    'referenceTypes' => $referenceTypes,
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
                'min_entries' => 1,
                'max_entries' => 10,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'clearfix' => self::$visibilitySm,
                    'data-display-sum' => 'ability',
                ],
                'options' => [
                    'referenceTypes' => $referenceTypes,
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
                'min_entries' => 1,
                'max_entries' => 10,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'clearfix' => self::$visibilityMd.self::$visibilityLg,
                    'data-display-sum' => 'ability',
                ],
                'options' => [
                    'referenceTypes' => $referenceTypes,
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
                'min_entries' => 1,
                'max_entries' => 10,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'clearfix' => self::$visibilitySm,
                    'data-display-sum' => 'ability',
                ],
                'options' => [
                    'referenceTypes' => $referenceTypes,
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
                'min_entries' => 1,
                'max_entries' => 10,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'data-display-sum' => 'ability',
                ],
                'options' => [
                    'referenceTypes' => $referenceTypes,
                ]
            ))
            ->add('CharismaAbility', 'collection_prototype', array(
                'label' => 'Charisme',
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'type' => 'modificator',
                'prototype' => true,
                'by_reference' => false,
                'unique_fields' => ['type'],
                'min_entries' => 1,
                'max_entries' => 10,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                    'data-display-sum' => 'ability',
                ],
                'options' => [
                    'referenceTypes' => $referenceTypes,
                ]
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