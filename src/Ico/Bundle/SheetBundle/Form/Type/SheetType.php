<?php

namespace Ico\Bundle\SheetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SheetType extends AbstractType
{
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
            ))
            ->add('create', 'submit', array('label' => 'Sauvegarder'));
    }

    public function getName()
    {
        return 'sheet';
    }
}