<?php

namespace Ico\Bundle\TrainingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ico\Bundle\MassFightBundle\Entity\Benefit;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Benefits implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {
    
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {
        $benefit1 = new Benefit();
        $benefit1->setName('Attaques éclair');
        $benefit1->setDescription('Le commandant a entraîné son armée à
lancer de rapides attaques suivies d’une retraite. Une fois que l’armée a lancé une attaque lors de la phase à distance ou au corps à corps, elle bénéficie d’un bonus de +2 au test
de moral opposé si elle utilise la tactique battre en retraite. Pour choisir ce don, le commandant doit avoir une valeur de prestige de 5 ou plus. À partir de 10, le bonus passe à +4.');
        $benefit1->setMinPrestige(5);
        $manager->persist($benefit1);
        
        $benefit3 = new Benefit();
        $benefit3->setName('Blessé mais pas brisé');
        $benefit3->setDescription('Le commandant inspire tant son armée qu’elle donne le meilleur d’elle-même quand la situation devient désespérée. Quand ses points de vie sont réduits de moitié ou plus, elle gagne un bonus de +1 aux tests d’attaque.
Pour choisir ce bienfait, le commandant doit avoir un prestige de 4 ou plus. À partir de 10 ou plus, le bonus passe à +2.');
        $benefit1->setMinPrestige(4);
        $manager->persist($benefit3);
        
        $benefit4 = new Benefit();
        $benefit4->setName('Flexibilité tactique');
        $benefit4->setDescription('Le commandant a entraîné son armée à recevoir différents ordres au cours d’une même bataille. L’armée gagne un bonus de +5 aux tests de moral pour
changer de tactique en cours d’affrontement. Pour choisir ce don, le commandant doit avoir une valeur de prestige de 6 ou plus. À partir de 12, le bonus passe à +10.');
        $benefit1->setMinPrestige(6);
        $manager->persist($benefit4);
        
        $benefit5 = new Benefit();
        $benefit5->setName('Impitoyable');
        $benefit5->setDescription('Le commandant encourage son armée à se montrer impitoyable et à n’épargner aucun blessé. Elle gagne un bonus de +1 aux tests de moral pour empêcher une armée adverse de battre en retraite et au dernier test d’attaque contre une armée en déroute ou une armée qui utilise la tactique battre en retraite.');
        $manager->persist($benefit5);
        
        $benefit6 = new Benefit();
        $benefit6->setName('Loyauté');
        $benefit6->setDescription('Le commandant inspire une grande loyauté à son armée, qui gagne un bonus de +2 aux tests de moral. Pour choisir ce don, le commandant doit avoir une valeur de prestige de 6 ou plus. À partir de 12, le bonus passe à +4.');
        $benefit1->setMinPrestige(6);
        $manager->persist($benefit6);
        
        $benefit7 = new Benefit();
        $benefit7->setName('Se débrouiller sur place');
        $benefit7->setDescription('Le commandant peut ordonner à ses soldats de poser des collets, de chasser ou de pêcher pour augmenter les réserves de nourriture. Chaque semaine où le commandant utilise ce bienfait, réduisez la consommation mais aussi la vitesse de l’armée de moitié. Si le MJ le désire, les armées de taille TG ou plus pillent les ressources naturelles d’une région en 1d3 semaines. Elles doivent alors se déplacer si elles veulent continuer de réduire leur consommation.');
        $manager->persist($benefit7);
        
        $benefit8 = new Benefit();
        $benefit8->setName('Tactique défensive');
        $benefit8->setDescription('Le commandant a un don pour la défense. Augmentez la VDéf de l’armée de 2. Le commandant doit avoir une valeur de prestige de 5 ou plus pour choisir ce bienfait.');
        $benefit1->setMinPrestige(5);
        $manager->persist($benefit8);
        
        $benefit9 = new Benefit();
        $benefit9->setName('Tactique supplémentaire');
        $benefit9->setDescription('Choisissez une tactique. Le commandant la connaît toujours et son armée peut l’utiliser même si elle ne la connaît pas. Vous pouvez choisir ce bienfait
à plusieurs reprises mais vous devez choisir une nouvelle tactique à chaque fois.');
        $manager->persist($benefit9);
        
        $benefit10 = new Benefit();
        $benefit10->setName('Tenir la ligne');
        $benefit10->setDescription('Le commandant sait entretenir le moral de son armée face à de dangereux adversaires. Si son armée rate son test de moral pour éviter la déroute, elle peut refaire le test. Elle doit conserver le résultat du second, même s’il est pire.');
        $manager->persist($benefit10);
        
        $benefit11 = new Benefit();
        $benefit11->setName('Tireur d’élite');
        $benefit11->setDescription('Le commandant a entraîné son armée à améliorer la précision de ses attaques à distance. Elle gagne un bonus de +2 aux tests d’attaque contre les armées retranchées derrière des fortifications. Cet avantage n’a aucun effet sur une armée incapable d’attaquer à distance.');
        $manager->persist($benefit11);

        $benefit12 = new Benefit();
        $benefit12->setName('Tri des patients');
        $benefit12->setDescription('Le commandant recourt à des méthodes magiques, alchimiques ou traditionnelles pour entraîner son armée à prodiguer des soins d’urgence. Une fois par bataille, l’armée peut subir un malus de –4 au test d’attaque d’une phase à distance ou au corps à corps pour soigner un montant de dégâts égal à la moitié de son FPA. Si elle possède la ressource potions de soins, elle bénéficie aussi des soins associés à ce don quand elle utilise ses potions (sans subir de malus au test d’attaque).');
        $manager->persist($benefit12);

	   $manager->flush();
    }

    public function getOrder() {
	   return 18;
    }
}
