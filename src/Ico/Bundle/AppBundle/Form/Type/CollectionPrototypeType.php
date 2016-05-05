<?php

namespace Ico\Bundle\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

class CollectionPrototypeType extends AbstractType
{    
    public function getParent()
    {
        return 'collection';
    }

    public function getName()
    {
        return 'collection_prototype';
    }
}