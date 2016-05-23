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

class SheetFightSectionType extends AbstractSectionType
{
    use ResponsiveFormTypeTrait;
    
    /** @var EntityManager */
    private $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    protected function getDisplayName()
    {
        return 'Combat';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $referenceTypesAttack = [
            'Taille' => 'Taille',
            'Spécial' => 'Spécial',
        ];
        $this->setBuilder($builder)
            ->add('bba', null, array(
                'label' => 'BBA',
                'attr' => [
                    'formGroupClass' => self::$inputExtraSmall,
                ],
            ))
            ->add('contactAttack', 'collection_prototype', array(
                'label' => 'Attaque au corps-à-corps',
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'type' => 'modificator',
                'prototype' => true,
                'by_reference' => false,
                'unique_fields' => ['type'],
                'auto_calculated_total' => 'default',
                'auto_calculated_fields' => [
                    'bba' => 'value',
                    'strengthAbility' => 'mod',
                ],
                'min_entries' => 3,
                'max_entries' => 10,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                ],
                'options' => [
                    'referenceTypes' => $referenceTypesAttack,
                ]
            ))
            ->add('rangedAttack', 'collection_prototype', array(
                'label' => 'Attaque à distance',
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'type' => 'modificator',
                'prototype' => true,
                'by_reference' => false,
                'unique_fields' => ['type'],
                'auto_calculated_total' => 'default',
                'auto_calculated_fields' => [
                    'bba' => 'value',
                    'dexterityAbility' => 'mod',
                ],
                'min_entries' => 3,
                'max_entries' => 10,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                ],
                'options' => [
                    'referenceTypes' => $referenceTypesAttack,
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
        return 'sheet_fight_section';
    }
}