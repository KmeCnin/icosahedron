<?php

namespace Ico\Bundle\AppBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Twig_Extension;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

class Extension extends Twig_Extension
{
    protected $container;
    
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }
    
    public function getFunctions()
    {
        return array(
            'classId' => new Twig_SimpleFunction('classId', array($this, 'classId'))
        );
    }
    
    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('environment', array($this, 'environmentFilter')),
        );
    }
    
    public function classId($class)
    {
        return new ObjectIdentity('class', $class);
    }

    public function environmentFilter($text)
    {
        // Remplacement de {{ROOT}} par l'url de la racine de l'application
	   $root = $this->container->get('router')->getContext()->getBaseUrl();
	   $text = preg_replace('/{{ROOT}}/', $root, $text);

        return $text;
    }

    public function getName()
    {
        return 'extension';
    }
}