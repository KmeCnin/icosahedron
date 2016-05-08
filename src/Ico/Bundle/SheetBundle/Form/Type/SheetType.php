<?php

namespace Ico\Bundle\SheetBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Ico\Bundle\RulesBundle\Entity\SizeCategory;
use Ico\Bundle\SheetBundle\Entity\Sheet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SheetType extends AbstractType
{
    /** @var EntityManager */
    private $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('characterName', null, array('label' => 'Nom du personnage'))
            ->add('classLevels', 'collection_prototype', array(
                'label' => 'Classes et niveaux',
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'type' => 'classLevel',
                'prototype' => true,
                'by_reference' => false,
                'unique_fields' => ['characterClass'],
                'min_entries' => 1,
                'max_entries' => 10,
            ))
            ->add('sizeCategory', 'entity', array(
                'label' => 'Catégorie de taille',
                'class' => SizeCategory::class,
                'property' => 'name',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('size')
                        ->orderBy('size.id', 'ASC');
                },
                'data' => $this->em->getReference("IcoRulesBundle:SizeCategory", 5)
            ))
            ->add('create', 'submit', array('label' => 'Sauvegarder'));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Sheet::class,
        ));
    }

    public function getName()
    {
        return 'sheet';
    }
}