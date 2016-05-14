<?php

namespace Ico\Bundle\SheetBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Ico\Bundle\AppBundle\Form\AbstractSectionType;
use Ico\Bundle\AppBundle\Form\TypeTrait\ResponsiveFormTypeTrait;
use Ico\Bundle\RulesBundle\Entity\Gender;
use Ico\Bundle\RulesBundle\Entity\SizeCategory;
use Ico\Bundle\SheetBundle\Entity\Calculation;
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
            ->add('forceAbility', null, array(
                'label' => 'Force',
                'class' => Calculation::class,
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