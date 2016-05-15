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
        $this->setBuilder($builder)
            ->add('forceAbility', 'collection_prototype', array(
                'label' => 'Force',
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'type' => 'modificator',
                'prototype' => true,
                'by_reference' => false,
                'unique_fields' => ['type'],
                'min_entries' => 1,
                'max_entries' => 20,
                'attr' => [
                    'formGroupClass' => self::$inputDefault,
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