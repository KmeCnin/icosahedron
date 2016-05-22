<?php

namespace Ico\Bundle\SheetBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Ico\Bundle\AppBundle\Form\BuilderAugmenter;
use Ico\Bundle\AppBundle\Form\TypeTrait\ResponsiveFormTypeTrait;
use Ico\Bundle\SheetBundle\Entity\Sheet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SheetType extends AbstractType
{
    use ResponsiveFormTypeTrait;
    
    /** @var BuilderAugmenter */
    private $builderAugmenter;
    
    public function __construct(BuilderAugmenter $builderAugmenter) {
        $this->builderAugmenter = $builderAugmenter;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->builderAugmenter->setBuilder($builder)
            ->add('sheet_description_section', $options)
            ->add('sheet_statistics_section', $options)
            ->add('sheet_fight_section', $options)
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
        return 'sheet';
    }
}