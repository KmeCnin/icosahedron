<?php

namespace Ico\Bundle\KingmakerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CampaignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('label' => 'Nom'))
            ->add('description', 'textarea', array('label' => 'Déscription', 'required' => false))
            ->add('create', 'submit', array('label' => 'Sauvegarder'));
    }

    public function getName()
    {
        return 'campaign';
    }
}