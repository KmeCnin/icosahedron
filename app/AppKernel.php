<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface; 

// setting the default time zone
date_default_timezone_set('Europe/Paris');

class AppKernel extends Kernel {

    public function registerBundles() {
        $bundles = array(
            // Native
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            // Third parties 
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
		  new JMS\SerializerBundle\JMSSerializerBundle(),
            new Ico\Bundle\UserBundle\IcoUserBundle(),
            new Ico\Bundle\AppBundle\IcoAppBundle(),
            new Ico\Bundle\HelperBundle\IcoHelperBundle(),
            new Ico\Bundle\RulesBundle\IcoRulesBundle(),
            new Ico\Bundle\ParserBundle\IcoParserBundle(),
            new Ico\Bundle\KingmakerBundle\IcoKingmakerBundle(),
            new Ico\Bundle\SheetBundle\IcoSheetBundle(),
            new Ico\Bundle\MassFightBundle\IcoMassFightBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader) {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
