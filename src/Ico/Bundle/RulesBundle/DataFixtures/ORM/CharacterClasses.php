<?php

namespace Kiwi\Bundle\TrainingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ico\Bundle\RulesBundle\Entity\CharacterClass;
use Ico\Bundle\RulesBundle\Entity\Link;
//use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CharacterClasses implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

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
	   
	   $classes = array(
		  array(
			 'name' => 'Magicien',
			 'nameId' => 'magicien',
			 'description' => 'Au-delà du voile du monde de tous les jours se cachent les mystères du pouvoir absolu. Les œuvres des êtres supérieurs aux mortels, les légendes des royaumes où vivent les dieux et les esprits, les actes créateurs à la fois merveilleux et terribles… tous ces mystères intriguent ceux qui possèdent l’ambition et les capacités nécessaires pour s’élever au-dessus du commun des mortels et atteindre le pouvoir véritable. C’est la voie des magiciens. Ces individus à l’esprit affûté recherchent, collectent et convoitent les connaissances ésotériques et se servent d’arts connus seulement d’une poignée de personnes pour réaliser des merveilles allant au-delà de la portée des simples mortels. Certains choisissent un domaine d’étude magique spécifique et deviennent des experts d’une certaine catégorie de pouvoirs, alors que d’autres optent pour la versatilité et jouissent de toute l’étendue des merveilles magiques. Dans tous les cas, l’ingéniosité et la puissance des magiciens sont évidentes : ils peuvent détruire leurs ennemis, renforcer leurs alliés et façonner le monde selon leurs désirs.',
			 'role' => ' Alors que les études des magiciens généralistes leur permettent de se préparer à n’importe quel type de danger, les magiciens spécialistes s’intéressent à des <a class="pagelink" href="Pathfinder-RPG.%c3%a9coles%20de%20magie.ashx" title="Les écoles de magie">écoles de magie</a> qui les rendent particulièrement efficaces dans un domaine spécifique. Mais, quelle que soit la voie choisie, tous les magiciens sont des maîtres de l’impossible, capables d’aider leurs alliés à faire face à n’importe quelle menace.',
			 'alignment' => 'Au choix',
			 'hitDie' => 'd6',
			 'skills' => array('Art de la magie', 'Artisanat', 'Connaissances', 'Estimation', 'Linguistique', 'Profession', 'Vol'),
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Magicien.ashx',
			 'baseSkillPoints' => 2
		  )
	   );

	   foreach ($classes as $data) {
		  $class = new CharacterClass();
		  $class->setName($data['name']);
		  $class->setNameId($data['nameId']);
		  $class->setDescription($data['description']);
		  $class->setRole($data['role']);
		  $class->setAlignment($data['alignment']);
		  $class->setHitDie($data['hitDie']);
		  $class->setBaseSkillPoints($data['baseSkillPoints']);
		  
		  foreach ($data['skills'] as $name) {
			 $skill = $this->container->get('doctrine')
				->getRepository('IcoRulesBundle:Skill')
				->findOneByName($name);
			 $class->addSkill($skill);
		  }
		  
		  $d = parse_url($data['link']);
		  $source = $this->container->get('doctrine')
				->getRepository('IcoRulesBundle:LinkSource')
				->findOneByDomain($d['host']);
		  $link = new Link();
		  $link->setSource($source);
		  $link->setUrl($data['link']);
		  $class->setLink($link);
		  
		  $manager->persist($class);
	   }
	   $manager->flush();
    }

    public function getOrder() {
	   return 13;
    }

}
