<?php

namespace Ico\Bundle\TrainingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ico\Bundle\MassFightBundle\Entity\Tactic;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Tactics implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {
    
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
        $tactic1 = new Tactic();
        $tactic1->setName('Combat prudent');
        $tactic1->setDescription('Votre armée se bat prudemment pour préserver son moral. Son MA diminue de 2 mais elle gagne un bonus de +2 aux tests de moral.');
        $tactic1->setMa(-2);
        $tactic1->setMoral(2);
        $manager->persist($tactic1);
        
        $tactic3 = new Tactic();
        $tactic3->setName('Cavaliers experts');
        $tactic3->setDescription('Le MA de votre armée augmente de 2 contre les armées qui n\'ont pas de montures. Pour utiliser cette tactique, l’armée doit avoir la ressource monture.');
        $tactic3->setMa(2);
        $manager->persist($tactic3);
        
        $tactic4 = new Tactic();
        $tactic4->setName('Mur protecteur');
        $tactic4->setDescription('Votre armée se bat sur la défensive, ses soldats se protégeant les uns les autres. Son MA diminue de 2 mais sa VDéf augmente de 2.');
        $tactic4->setMa(-2);
        $tactic4->setVD(2);
        $manager->persist($tactic4);
        
        $tactic5 = new Tactic();
        $tactic5->setName('Sales coups');
        $tactic5->setDescription('Votre armée n’hésite pas à donner dans la supercherie et le combat déloyal pour prendre l’avantage en début d’affrontement. Son MA augmente de 6 lors d’une phase de corps à corps. (Après cette phase, l’armée adverse a compris qu’elle devait se méfier de ces astuces.)');
        $tactic5->setMa(6);
        $manager->persist($tactic5);
        
        $tactic6 = new Tactic();
        $tactic6->setName('Spécialistes de l’encerclement');
        $tactic6->setDescription('Votre armée est très douée pour encercler ses ennemis et détourner leur attention mais elle s’éparpille énormément et devient plus vulnérable. Augmentez son MA de 2 et réduisez sa VDéf de 2.');
        $tactic6->setMa(2);
        $tactic6->setVD(-2);
        $manager->persist($tactic6);
        
        $tactic7 = new Tactic();
        $tactic7->setName('Fausse retraite');
        $tactic7->setDescription('Une fois par combat, l’armée peut faire semblant de battre en retraite pour attirer l’ennemi au coeur de son territoire. Lors de la phase où vous faites semblant de vous retirer, vous ne pouvez pas faire de test d’attaque. En revanche, lors de la phase suivante, votre MA et votre VDéf
augmentent de 6 contre l’armée visée.');
        $tactic7->setMa(6);
        $tactic7->setVD(6);
        $manager->persist($tactic7);
        
        $tactic8 = new Tactic();
        $tactic8->setName('Défense totale');
        $tactic8->setDescription('L’armée se concentre pleinement sur la défense. Sa VDéf augmente de 4 mais son MA diminue de 4.');
        $tactic8->setMa(-4);
        $tactic8->setVD(4);
        $manager->persist($tactic8);
        
        $tactic9 = new Tactic();
        $tactic9->setName('Brutes infatigables');
        $tactic9->setDescription('L’armée jette toute prudence aux orties et attaque sauvagement, dans une frénésie sanglante. Elle augmente son MA de 4 et diminue sa VDéf de 4.');
        $tactic9->setMa(4);
        $tactic9->setVD(-4);
        $manager->persist($tactic9);
        
        $tactic10 = new Tactic();
        $tactic10->setName('Briseurs de siège');
        $tactic10->setDescription('L’armée se concentre sur les armes de siège ennemies et tente de les détruire. À chaque fois que l’armée blesse une armée ennemie, elle fait un deuxième test d’attaque. Si elle le réussit, elle détruit l’une des armes de siège de l’adversaire. Cette tactique n’a aucun effet si l’armée adverse ne possède pas d’arme de siège.');
        $manager->persist($tactic10);
        
        $tactic11 = new Tactic();
        $tactic11->setName('Snipers en soutien');
        $tactic11->setDescription('Votre armée garde quelques unités de combat à distance en réserve pour les utiliser lors de la phase de corps à corps. Si votre armée blesse l’armée adverse lors de la phase de corps à corps, elle lui inflige 2 points de dégâts de plus grâce à ses archers. Pour utiliser cette tactique, votre armée doit être capable d’attaquer à distance.');
        $tactic11->setDamages(2);
        $manager->persist($tactic11);
        
        $tactic12 = new Tactic();
        $tactic12->setName('Briseurs de sorts');
        $tactic12->setDescription('Votre armée possède des soldats spécialisés dans l’interruption des incantations. Elle augmente sa VDéf de 4 quand elle affronte une armée dotée du pouvoir incantation.');
        $tactic12->setVD(4);
        $manager->persist($tactic12);
        
        $tactic13 = new Tactic();
        $tactic13->setName('Standard');
        $tactic13->setDescription('Les attaques de votre armée ne bénéficient d’aucun modificateur au MA ni à la VDéf.');
        $tactic13->setIsDefault(true);
        $manager->persist($tactic13);
        
        $tactic14 = new Tactic();
        $tactic14->setName('Raillerie');
        $tactic14->setDescription('Votre armée est particulièrement douée pour provoquer l’ennemi et le pousser à faire des erreurs stupides et à se montrer bien trop confiant. L’ennemi doit faire un test de moral (DD = 10 + FPA de votre armée) au début de chaque phase à distance ou au corps à corps. En cas d’échec, sa VDéf et son MA diminuent de 2 pour la phase. Si l’ennemi réussit deux jets de sauvegarde consécutifs contre les railleries, il est immunisé contre cette tactique pour le reste de la bataille.');
        $manager->persist($tactic14);
        
        $tactic15 = new Tactic();
        $tactic15->setName('Battre en retraite');
        $tactic15->setDescription('Votre armée tente d’échapper à toutes celles qui l’attaquent. Elle doit faire un test de moral opposé à celui de chaque armée qui l’attaque si elle veut conserver un semblant de discipline (sachant qu’une armée peut rater volontairement ce test). Elle n’a pas besoin de faire de test de moral pour passer d’une autre tactique à celle-ci. Si votre armée réussit tous ses tests, elle peut se retirer du champ de bataille ou passer à une phase à distance. Si l’armée ne réussit qu’une partie de ses tests, elle peut se retirer ou passer à une phase à distance mais les armées adverses peuvent l’attaquer comme si elle était au corps à corps. Que l’armée réussisse ou non ses tests, son MA et sa VDéf sont réduits de 2 pour le reste de la phase.');
        $tactic15->setMa(-2);
        $tactic15->setVd(-2);
        $tactic15->setIsDefault(true);
        $manager->persist($tactic15);
        
	   $manager->flush();
    }

    public function getOrder() {
	   return 17;
    }

}
