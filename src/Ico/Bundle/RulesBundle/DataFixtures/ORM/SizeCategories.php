<?php

namespace Ico\Bundle\TrainingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ico\Bundle\RulesBundle\Entity\SizeCategory;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SizeCategories implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {
    
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
	   
	   $entries = array(
		  array(
			 'name' => 'Infime',
			 'short' => 'I',
			 'space' => '15 cm',
			 'reach_h' => '0',
			 'reach_v' => '0',
			 'description' => "Les créatures de taille très réduite occupent moins d'une case. Cela signifie que plusieurs d'entre elles peuvent tenir dans la même case. Une créature de taille TP occupe un espace de 75 cm de côté, quatre d'entre elles peuvent donc occuper une même case. Vingt-cinq créatures de taille Min ou cent de taille I peuvent se tenir sur une même case.<br><br>Les créatures qui occupent un espace inférieur à une case ont généralement une allonge naturelle de 0 mètre et ne peuvent atteindre un ennemi qui se trouve sur une case adjacente. Pour se battre, elles doivent impérativement pénétrer dans l'espace occupé par leur adversaire, ce qui les expose automatiquement à une <a class=\"pagelink\" href=\"Pathfinder-RPG.attaque%20dopportunit%c3%a9.ashx\" title=\"attaque d'opportunité\">attaque d'opportunité</a>  de sa part.<br><br>Un personnage peut attaquer ces créatures si besoin et peut donc les attaquer normalement. Comme ces créatures n'ont pas d'allonge naturelle, elles ne contrôlent pas les cases adjacentes. Un personnage peut donc passer à côté d'elles sans provoquer d'<a class=\"pagelink\" href=\"Pathfinder-RPG.attaque%20dopportunit%c3%a9.ashx\" title=\"attaque d'opportunité\">attaque d'opportunité</a>. Ces créatures sont incapables de <a class=\"pagelink\" href=\"Pathfinder-RPG.prise%20en%20tenaille.ashx\" title=\"prise en tenaille\">prendre un ennemi en tenaille</a>.",
		  ),
		  array(
			 'name' => 'Minuscule',
			 'short' => 'Min',
			 'space' => '30 cm',
			 'reach_h' => '0',
			 'reach_v' => '0',
			 'description' => "Les créatures de taille très réduite occupent moins d'une case. Cela signifie que plusieurs d'entre elles peuvent tenir dans la même case. Une créature de taille TP occupe un espace de 75 cm de côté, quatre d'entre elles peuvent donc occuper une même case. Vingt-cinq créatures de taille Min ou cent de taille I peuvent se tenir sur une même case.<br><br>Les créatures qui occupent un espace inférieur à une case ont généralement une allonge naturelle de 0 mètre et ne peuvent atteindre un ennemi qui se trouve sur une case adjacente. Pour se battre, elles doivent impérativement pénétrer dans l'espace occupé par leur adversaire, ce qui les expose automatiquement à une <a class=\"pagelink\" href=\"Pathfinder-RPG.attaque%20dopportunit%c3%a9.ashx\" title=\"attaque d'opportunité\">attaque d'opportunité</a>  de sa part.<br><br>Un personnage peut attaquer ces créatures si besoin et peut donc les attaquer normalement. Comme ces créatures n'ont pas d'allonge naturelle, elles ne contrôlent pas les cases adjacentes. Un personnage peut donc passer à côté d'elles sans provoquer d'<a class=\"pagelink\" href=\"Pathfinder-RPG.attaque%20dopportunit%c3%a9.ashx\" title=\"attaque d'opportunité\">attaque d'opportunité</a>. Ces créatures sont incapables de <a class=\"pagelink\" href=\"Pathfinder-RPG.prise%20en%20tenaille.ashx\" title=\"prise en tenaille\">prendre un ennemi en tenaille</a>.",
		  ),
		  array(
			 'name' => 'Très petite',
			 'short' => 'TP',
			 'space' => '75 cm',
			 'reach_h' => '0',
			 'reach_v' => '0',
			 'description' => "Les créatures de taille très réduite occupent moins d'une case. Cela signifie que plusieurs d'entre elles peuvent tenir dans la même case. Une créature de taille TP occupe un espace de 75 cm de côté, quatre d'entre elles peuvent donc occuper une même case. Vingt-cinq créatures de taille Min ou cent de taille I peuvent se tenir sur une même case.<br><br>Les créatures qui occupent un espace inférieur à une case ont généralement une allonge naturelle de 0 mètre et ne peuvent atteindre un ennemi qui se trouve sur une case adjacente. Pour se battre, elles doivent impérativement pénétrer dans l'espace occupé par leur adversaire, ce qui les expose automatiquement à une <a class=\"pagelink\" href=\"Pathfinder-RPG.attaque%20dopportunit%c3%a9.ashx\" title=\"attaque d'opportunité\">attaque d'opportunité</a>  de sa part.<br><br>Un personnage peut attaquer ces créatures si besoin et peut donc les attaquer normalement. Comme ces créatures n'ont pas d'allonge naturelle, elles ne contrôlent pas les cases adjacentes. Un personnage peut donc passer à côté d'elles sans provoquer d'<a class=\"pagelink\" href=\"Pathfinder-RPG.attaque%20dopportunit%c3%a9.ashx\" title=\"attaque d'opportunité\">attaque d'opportunité</a>. Ces créatures sont incapables de <a class=\"pagelink\" href=\"Pathfinder-RPG.prise%20en%20tenaille.ashx\" title=\"prise en tenaille\">prendre un ennemi en tenaille</a>.",
		  ),
		  array(
			 'name' => 'Petite',
			 'short' => 'P',
			 'space' => '1,50 m',
			 'reach_h' => '1,50 m',
			 'reach_v' => '1,50 m',
			 'description' => "",
		  ),
		  array(
			 'name' => 'Moyenne',
			 'short' => 'M',
			 'space' => '1,50 m',
			 'reach_h' => '1,50 m',
			 'reach_v' => '1,50 m',
			 'description' => "",
		  ),
		  array(
			 'name' => 'Grande',
			 'short' => 'G',
			 'space' => '3 m',
			 'reach_h' => '1,50 m',
			 'reach_v' => '3 m',
			 'description' => "Les créatures de taille très supérieure à la moyenne occupent plusieurs cases.<br><br>Les créatures qui occupent plus d'une case ont généralement une allonge naturelle de 3 m ou plus, ce qui signifie qu'elles peuvent atteindre des ennemis qui ne sont pas adjacents.<br><br>Contrairement à une personne qui utilise une arme à allonge, une créature bénéficiant d'une allonge naturelle supérieure à 1,50 m menacent aussi les cases adjacentes. Une créature qui dispose d'une allonge naturelle supérieure à la normale bénéficie habituellement d'une <a class=\"pagelink\" href=\"Pathfinder-RPG.attaque%20dopportunit%c3%a9.ashx\" title=\"attaque d'opportunité\">attaque d'opportunité</a> contre les personnages qui essayent de l'approcher car ils doivent pénétrer dans l'espace qu'elle contrôle et s'y déplacer avant de pouvoir l'attaquer. En revanche, si le personnage fait un <a class=\"pagelink\" href=\"Pathfinder-RPG.pas%20de%20placement.ashx\" title=\"Pas de placement\">pas de placement</a> de 1,50 mètre, il ne provoque pas d'<a class=\"pagelink\" href=\"Pathfinder-RPG.attaque%20dopportunit%c3%a9.ashx\" title=\"attaque d'opportunité\">attaque d'opportunité</a>.<br><br>Les créatures de taille G ou plus qui utilisent une arme à allonge peuvent attaquer des adversaires situés à une distance égale au double de leur allonge naturelle, en revanche, elles ne peuvent pas frapper quelqu'un se trouvant à une distance égale ou inférieure à leur allonge naturelle.",
		  ),
		  array(
			 'name' => 'Très grande',
			 'short' => 'TG',
			 'space' => '4,50 m',
			 'reach_h' => '3 m',
			 'reach_v' => '4,50 m',
			 'description' => "Les créatures de taille très supérieure à la moyenne occupent plusieurs cases.<br><br>Les créatures qui occupent plus d'une case ont généralement une allonge naturelle de 3 m ou plus, ce qui signifie qu'elles peuvent atteindre des ennemis qui ne sont pas adjacents.<br><br>Contrairement à une personne qui utilise une arme à allonge, une créature bénéficiant d'une allonge naturelle supérieure à 1,50 m menacent aussi les cases adjacentes. Une créature qui dispose d'une allonge naturelle supérieure à la normale bénéficie habituellement d'une <a class=\"pagelink\" href=\"Pathfinder-RPG.attaque%20dopportunit%c3%a9.ashx\" title=\"attaque d'opportunité\">attaque d'opportunité</a> contre les personnages qui essayent de l'approcher car ils doivent pénétrer dans l'espace qu'elle contrôle et s'y déplacer avant de pouvoir l'attaquer. En revanche, si le personnage fait un <a class=\"pagelink\" href=\"Pathfinder-RPG.pas%20de%20placement.ashx\" title=\"Pas de placement\">pas de placement</a> de 1,50 mètre, il ne provoque pas d'<a class=\"pagelink\" href=\"Pathfinder-RPG.attaque%20dopportunit%c3%a9.ashx\" title=\"attaque d'opportunité\">attaque d'opportunité</a>.<br><br>Les créatures de taille G ou plus qui utilisent une arme à allonge peuvent attaquer des adversaires situés à une distance égale au double de leur allonge naturelle, en revanche, elles ne peuvent pas frapper quelqu'un se trouvant à une distance égale ou inférieure à leur allonge naturelle.",
		  ),
		  array(
			 'name' => 'Gigantesque',
			 'short' => 'Gig',
			 'space' => '6 m',
			 'reach_h' => '4,50 m',
			 'reach_v' => '6 m',
			 'description' => "Les créatures de taille très supérieure à la moyenne occupent plusieurs cases.<br><br>Les créatures qui occupent plus d'une case ont généralement une allonge naturelle de 3 m ou plus, ce qui signifie qu'elles peuvent atteindre des ennemis qui ne sont pas adjacents.<br><br>Contrairement à une personne qui utilise une arme à allonge, une créature bénéficiant d'une allonge naturelle supérieure à 1,50 m menacent aussi les cases adjacentes. Une créature qui dispose d'une allonge naturelle supérieure à la normale bénéficie habituellement d'une <a class=\"pagelink\" href=\"Pathfinder-RPG.attaque%20dopportunit%c3%a9.ashx\" title=\"attaque d'opportunité\">attaque d'opportunité</a> contre les personnages qui essayent de l'approcher car ils doivent pénétrer dans l'espace qu'elle contrôle et s'y déplacer avant de pouvoir l'attaquer. En revanche, si le personnage fait un <a class=\"pagelink\" href=\"Pathfinder-RPG.pas%20de%20placement.ashx\" title=\"Pas de placement\">pas de placement</a> de 1,50 mètre, il ne provoque pas d'<a class=\"pagelink\" href=\"Pathfinder-RPG.attaque%20dopportunit%c3%a9.ashx\" title=\"attaque d'opportunité\">attaque d'opportunité</a>.<br><br>Les créatures de taille G ou plus qui utilisent une arme à allonge peuvent attaquer des adversaires situés à une distance égale au double de leur allonge naturelle, en revanche, elles ne peuvent pas frapper quelqu'un se trouvant à une distance égale ou inférieure à leur allonge naturelle.",
		  ),
		  array(
			 'name' => 'Colossale',
			 'short' => 'C',
			 'space' => '9 m',
			 'reach_h' => '6 m',
			 'reach_v' => '9 m',
			 'description' => "Les créatures de taille très supérieure à la moyenne occupent plusieurs cases.<br><br>Les créatures qui occupent plus d'une case ont généralement une allonge naturelle de 3 m ou plus, ce qui signifie qu'elles peuvent atteindre des ennemis qui ne sont pas adjacents.<br><br>Contrairement à une personne qui utilise une arme à allonge, une créature bénéficiant d'une allonge naturelle supérieure à 1,50 m menacent aussi les cases adjacentes. Une créature qui dispose d'une allonge naturelle supérieure à la normale bénéficie habituellement d'une <a class=\"pagelink\" href=\"Pathfinder-RPG.attaque%20dopportunit%c3%a9.ashx\" title=\"attaque d'opportunité\">attaque d'opportunité</a> contre les personnages qui essayent de l'approcher car ils doivent pénétrer dans l'espace qu'elle contrôle et s'y déplacer avant de pouvoir l'attaquer. En revanche, si le personnage fait un <a class=\"pagelink\" href=\"Pathfinder-RPG.pas%20de%20placement.ashx\" title=\"Pas de placement\">pas de placement</a> de 1,50 mètre, il ne provoque pas d'<a class=\"pagelink\" href=\"Pathfinder-RPG.attaque%20dopportunit%c3%a9.ashx\" title=\"attaque d'opportunité\">attaque d'opportunité</a>.<br><br>Les créatures de taille G ou plus qui utilisent une arme à allonge peuvent attaquer des adversaires situés à une distance égale au double de leur allonge naturelle, en revanche, elles ne peuvent pas frapper quelqu'un se trouvant à une distance égale ou inférieure à leur allonge naturelle.",
		  ),
	   );

	   foreach ($entries as $data) {
		  $entry = new SizeCategory();
		  $entry->setName($data['name']);
		  $entry->setShort($data['short']);
		  $entry->setDescription($data['description']);
		  $entry->setDefaultSpace($data['space']);
		  $entry->setDefaultReachHorizontal($data['reach_h']);
		  $entry->setDefaultReachVertical($data['reach_v']);
		  $manager->persist($entry);
	   }
	   $manager->flush();
    }

    public function getOrder() {
	   return 14;
    }

}
