<?php

namespace Kiwi\Bundle\TrainingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ico\Bundle\RulesBundle\Entity\Skill;
use Ico\Bundle\RulesBundle\Entity\Link;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Skills implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

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
	   
	   $skills = array(
		  array(
			 'name' => 'Acrobaties',
			 'untrained' => true,
			 'ability' => 'Dex',
			 'description' => 'Le personnage peut garder son équilibre lorsqu\'il marche sur des surfaces étroites ou un sol traître. Il peut également se baisser, se retourner, sauter ou effectuer un roulé-boulé pour éviter les coups ou traverser certains obstacles.',
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Acrobaties.ashx'
		  ),
		  array(
			 'name' => 'Art de la magie',
			 'untrained' => false,
			 'ability' => 'Int',
			 'description' => 'L\'art de lancer des sorts n\'a pas beaucoup de secrets pour le personnage. Il sait identifier les objets magiques, les fabriquer et reconnaître les sorts que d\'autres personnes lancent.',
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Art%20de%20la%20magie.ashx'
		  ),
		  array(
			 'name' => 'Artisanat',
			 'untrained' => true,
			 'ability' => 'Int',
			 'description' => 'Le personnage est entraîné à créer un type spécifique d\'objets (comme les armures ou les armes).',
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Artisanat.ashx'
		  ),
		  array(
			 'name' => 'Bluff',
			 'untrained' => true,
			 'ability' => 'Cha',
			 'description' => "Le personnage sait comment mentir.",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Bluff.ashx'
		  ),
		  array(
			 'name' => 'Connaissances',
			 'untrained' => false,
			 'ability' => 'Int',
			 'description' => "Le personnage possède des connaissances dans un domaine spécifique, qui lui permettent de répondre à des questions simples ou complexes.",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Connaissances.ashx'
		  ),
		  array(
			 'name' => 'Déguisement',
			 'untrained' => true,
			 'ability' => 'Cha',
			 'description' => "Le personnage sait comment changer d'apparence.",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.D%C3%A9guisement.ashx'
		  ),
		  array(
			 'name' => 'Diplomatie',
			 'untrained' => true,
			 'ability' => 'Cha',
			 'description' => "Le personnage peut utiliser cette compétence pour persuader quelqu'un de se ranger à son avis, pour résoudre un conflit ou encore pour récolter des informations ou se tenir au courant des rumeurs. Elle est également utile pour mener à bien des négociations tout en respectant l'étiquette et en adoptant les manières qui conviennent à une situation donnée.",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Diplomatie.ashx'
		  ),
		  array(
			 'name' => 'Discrétion',
			 'untrained' => true,
			 'ability' => 'Dex',
			 'description' => "Le personnage sait comment éviter de se faire repérer, ce qui lui permet de tromper la surveillance des gardes ou encore de se cacher et de se déplacer en silence pour pouvoir ensuite attaquer par surprise.",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Discr%C3%A9tion.ashx'
		  ),
		  array(
			 'name' => 'Dressage',
			 'untrained' => false,
			 'ability' => 'Cha',
			 'description' => "Le personnage sait comment s'y prendre avec les animaux et peut leur enseigner des tours, les faire obéir à des ordres simples ou même les apprivoiser.",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Dressage.ashx'
		  ),
		  array(
			 'name' => 'Équitation',
			 'untrained' => true,
			 'ability' => 'Dex',
			 'description' => "Le personnage sait monter à cheval ou utiliser d'autres montures plus exotiques comme un griffon ou un pégase. Si le personnage tente de chevaucher une créature qui n’est pas faite pour cela, il subit un malus de -5 sur ses tests d'Équitation.",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.%C3%89quitation.ashx'
		  ),
		  array(
			 'name' => 'Escalade',
			 'untrained' => true,
			 'ability' => 'For',
			 'description' => "Le personnage s'est entraîné à escalader toutes sortes de parois verticales, des murs relativement lisses de la ville jusqu'aux falaises rocailleuses.",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Escalade.ashx'
		  ),
		  array(
			 'name' => 'Escamotage',
			 'untrained' => false,
			 'ability' => 'Dex',
			 'description' => "Le personnage s'est entraîné à agir comme un pickpocket, à dissimuler des armes et à faire toute une série d'autres choses sans se faire remarquer.",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Escamotage.ashx'
		  ),
		  array(
			 'name' => 'Estimation',
			 'untrained' => true,
			 'ability' => 'Int',
			 'description' => "Le personnage sait estimer la valeur monétaire des objets.",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Estimation.ashx'
		  ),
		  array(
			 'name' => 'Évasion',
			 'untrained' => true,
			 'ability' => 'Dex',
			 'description' => "Le personnage s'est entraîné pour pouvoir se libérer de liens et se soustraire aux étreintes lors d'une lutte.",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.%C3%89vasion.ashx'
		  ),
		  array(
			 'name' => 'Intimidation',
			 'untrained' => true,
			 'ability' => 'Cha',
			 'description' => "Cette compétence permet au personnage d'effrayer ses adversaires ou de les contraindre à agir à son avantage grâce à des menaces verbales et à des démonstrations de force.",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Intimidation.ashx'
		  ),
		  array(
			 'name' => 'Linguistique',
			 'untrained' => false,
			 'ability' => 'Int',
			 'description' => "Le personnage s'est entraîné à bien manier les mots, à la fois oralement et par écrit. Il peut parler plusieurs langages et déchiffrer pratiquement n'importe quelle langue s'il dispose d'assez de temps. Il peut également contrefaire des documents écrits et repérer les faux en écriture.",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Linguistique.ashx'
		  ),
		  array(
			 'name' => 'Natation',
			 'untrained' => true,
			 'ability' => 'For',
			 'description' => "Le personnage a appris à nager et peut même le faire dans des eaux agitées.",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Natation.ashx'
		  ),
		  array(
			 'name' => 'Perception',
			 'untrained' => true,
			 'ability' => 'Sag',
			 'description' => "Les sens du personnage lui permettent de repérer certains détails et le préviennent des dangers imminents. La compétence de Perception regroupe les cinq sens : la vue, l'ouïe, le toucher, le goût et l'odorat.",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Perception.ashx'
		  ),
		  array(
			 'name' => 'Premiers secours',
			 'untrained' => true,
			 'ability' => 'Sag',
			 'description' => "Le personnage sait comment soigner les blessures et les autres maux.",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Premiers%20secours.ashx'
		  ),
		  array(
			 'name' => 'Profession',
			 'untrained' => false,
			 'ability' => 'Sag',
			 'description' => "Le personnage connaît les ficelles d'une profession en particulier.",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Profession.ashx'
		  ),
		  array(
			 'name' => 'Psychologie',
			 'untrained' => true,
			 'ability' => 'Sag',
			 'description' => "Le personnage sait comment repérer les mensonges et percevoir les intentions véritables des individus qu'il croise.",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Psychologie.ashx'
		  ),
		  array(
			 'name' => 'Représentation',
			 'untrained' => true,
			 'ability' => 'Cha',
			 'description' => "Le personnage connaît un ou plusieurs arts du spectacle (tels que chant, théâtre, instrument de musique).",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Repr%C3%A9sentation.ashx'
		  ),
		  array(
			 'name' => 'Sabotage',
			 'untrained' => false,
			 'ability' => 'Dex',
			 'description' => "Le personnage sait comment désamorcer les pièges et crocheter les serrures. Cette compétence lui permet également de saboter des objets mécaniques simples comme les catapultes, les roues d'un chariot et les portes.",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Sabotage.ashx'
		  ),
		  array(
			 'name' => 'Survie',
			 'untrained' => true,
			 'ability' => 'Sag',
			 'description' => "Le personnage sait comment survivre et se diriger dans les régions sauvages. Il est également entraîné à suivre les pistes ou les traces laissées par d'autres créatures.",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Survie.ashx'
		  ),
		  array(
			 'name' => 'Utilisation d\'objets magiques',
			 'untrained' => false,
			 'ability' => 'Cha',
			 'description' => "Le personnage sait comment activer des objets magiques, sans nécessairement être capable d'utiliser la magie par ailleurs.",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Utilisation%20dObjets%20Magiques.ashx'
		  ),
		  array(
			 'name' => 'Vol',
			 'untrained' => true,
			 'ability' => 'Dex',
			 'description' => "Lorsque le personnage vole (grâce à des ailes ou par magie), il sait le faire avec agilité. Il peut réaliser des manœuvres aériennes complexes ou dangereuses. Cette compétence ne lui donne cependant pas la capacité de voler.",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Vol.ashx'
		  ),
	   );

	   foreach ($skills as $data) {
		  $skill = new Skill();
		  $skill->setName($data['name']);
		  $skill->setUntrained($data['untrained']);
		  $skill->setDescription($data['description']);
		  $ability = $this->container->get('doctrine')
				->getRepository('IcoRulesBundle:Ability')
				->findOneByShort($data['ability']);
		  $skill->setAbility($ability);
		  
		  $d = parse_url($data['link']);
		  $source = $this->container->get('doctrine')
				->getRepository('IcoRulesBundle:LinkSource')
				->findOneByDomain($d['host']);
		  $link = new Link();
		  $link->setSource($source);
		  $link->setUrl($data['link']);
		  $skill->setLink($link);
		  
		  $crawler = new Crawler;
		  $crawler->addHTMLContent(file_get_contents($data['link']), 'UTF-8');
		  $htmlDescrition = '';
		  $wikiContent = $crawler->filter('#PageContentDiv');
		  foreach ($wikiContent as $domElement) {
			 $htmlDescrition .= $domElement->ownerDocument->saveHTML($domElement);
		  }
		  $detail_tmp = $this->string_between($htmlDescrition, '<br><h2 class="separator">Test de compétence', '<div class="voiraussi">', true);
		  $detail = $this->string_between($detail_tmp, '<br>', '<div class="voiraussi">', false);
		  if (empty($detail) || $detail == '<h') {
			 $detail_tmp = $this->string_between($htmlDescrition, '<br><h2 class="separator">Test de compétence', '</div>', true);
			 $detail = $this->string_between($detail_tmp, '<br>', '</div>', false);
		  }
		  $detail = str_replace('tablo', 'table table-striped', $detail);
		  $skill->setDetail($detail);
		  
		  $manager->persist($skill);
	   }
	   $manager->flush();
    }
    
    protected function string_between($string, $start, $end, $inclusive = false) { 
	   $fragments = explode($start, $string, 2);
	   if (isset($fragments[1])) {
		  $fragments = explode($end, $fragments[1], 2);
		  if ($inclusive) {
			 return $start.$fragments[0].$end;
		  } else {
			 return $fragments[0];
		  }
	   }
	   return false;
    }

    public function getOrder() {
	   return 12;
    }

}
