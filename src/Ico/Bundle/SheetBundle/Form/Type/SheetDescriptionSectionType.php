<?php

namespace Ico\Bundle\SheetBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Ico\Bundle\AppBundle\Form\AbstractSectionType;
use Ico\Bundle\AppBundle\Form\TypeTrait\ResponsiveFormTypeTrait;
use Ico\Bundle\RulesBundle\Entity\Gender;
use Ico\Bundle\RulesBundle\Entity\SizeCategory;
use Ico\Bundle\SheetBundle\Entity\Sheet;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SheetDescriptionSectionType extends AbstractSectionType
{
    use ResponsiveFormTypeTrait;
    
    /** @var EntityManager */
    private $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    protected function getDisplayName()
    {
        return 'Description';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->setBuilder($builder)
            ->add('characterName', null, array(
                'label' => 'Nom du personnage',
                'attr' => [
                    'formGroupClass' => self::$inputDefault,
                ],
            ))
            ->add('customRace', null, array(
                'label' => 'Race',
                'attr' => [
                    'formGroupClass' => self::$inputDefault,
                ],
            ))
            ->add('classLevels', 'collection_prototype', array(
                'label' => 'Classes et niveaux',
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'type' => 'class_level',
                'prototype' => true,
                'by_reference' => false,
                'unique_fields' => ['characterClass'],
                'min_entries' => 1,
                'max_entries' => 10,
                'attr' => [
                    'formGroupClass' => self::$inputSmall,
                ],
            ))
            ->add('sizeCategory', 'entity', array(
                'label' => 'Catégorie de taille',
                'class' => SizeCategory::class,
                'property' => 'name',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('size')
                        ->orderBy('size.id', 'ASC');
                },
                'data' => $this->em->getReference("IcoRulesBundle:SizeCategory", 5),
                'attr' => [
                    'formGroupClass' => self::$inputExtraSmall,
                ],
            ))
            ->add('gender', 'entity', array(
                'label' => 'Sexe',
                'class' => Gender::class,
                'property' => 'name',
                'attr' => [
                    'formGroupClass' => self::$inputExtraSmall,
                ],
            ))
            ->add('customReligion', null, array(
                'label' => 'Religion',
                'attr' => [
                    'formGroupClass' => self::$inputExtraSmall,
                ],
            ))
            ->add('customHomeland', null, array(
                'label' => 'Nation/origine',
                'attr' => [
                    'formGroupClass' => self::$inputExtraSmall,
                ],
            ))
            ->add('age', null, array(
                'label' => 'Age',
                'attr' => [
                    'formGroupClass' => self::$inputExtraSmall,
                ],
            ))
            ->add('weight', null, array(
                'label' => 'Poids (kg)',
                'attr' => [
                    'formGroupClass' => self::$inputExtraSmall,
                ],
            ))
            ->add('height', null, array(
                'label' => 'Taille (cm)',
                'attr' => [
                    'formGroupClass' => self::$inputExtraSmall,
                ],
            ))
            ->add('eyes', null, array(
                'label' => 'Yeux',
                'attr' => [
                    'formGroupClass' => self::$inputExtraSmall,
                ],
            ))
            ->add('hair', null, array(
                'label' => 'Cheveux',
                'attr' => [
                    'formGroupClass' => self::$inputExtraSmall,
                ],
            ))
            ->add('skin', null, array(
                'label' => 'Peau',
                'attr' => [
                    'formGroupClass' => self::$inputExtraSmall,
                ],
            ))
            ->add('hand', null, array(
                'label' => 'Dextrie',
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
        return 'sheet_description_section';
    }
}