<?php

namespace Ico\Bundle\TrainingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ico\Bundle\RulesBundle\Entity\Alignment;
use Ico\Bundle\RulesBundle\Entity\Link;
//use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Alignments implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {
    
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
	   $alignments = array(
		  array(
			 'name' => 'Loyal Bon',
			 'short' => 'LB',
			 'description' => 'L\'alignement Loyal Bon mêle honneur et compassion.',
			 'detail' => 'Un personnage Loyal Bon se comporte comme on l\'attend d\'un défenseur de l\'ordre et de la Loi. Déterminé à lutter contre le Mal, il est suffisamment discipliné pour ne jamais cesser le combat. Il dit toujours la vérité, reste fidèle à la parole donnée, aide ceux qui sont dans le besoin et se dresse contre l\'injustice. Il déteste voir les coupables impunis et s\'élève contre l\'injustice.',
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Alignement.ashx#Loyal_Bon_0'
		  ),
		  array(
			 'name' => 'Neutre Bon',
			 'short' => 'NB',
			 'description' => 'Être Neutre Bon permet de faire le Bien sans être bloqué par le carcan de la Loi.',
			 'detail' => 'Un personnage Neutre Bon fait de son mieux pour faire le bien. Il fait son possible pour aider les autres. Il travaille main dans la main avec les rois et les juges mais il ne se sent pas tenu de leur obéir.',
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Alignement.ashx#Neutre_Bon_1'
		  ),
		  array(
			 'name' => 'Chaotique Bon',
			 'short' => 'CB',
			 'description' => 'L\'alignement Chaotique Bon conjugue bonté et esprit libre.',
			 'detail' => 'Un personnage Chaotique Bon agit selon sa conscience, sans se soucier de ce que les autres pensent de lui. Il se comporte comme il l\'entend, mais cela ne l\'empêche pas d\'être gentil et bienveillant. Il croit à la bonté et au bon droit mais se moque des lois et des règles. Il déteste les gens qui intimident les autres et leur disent comment se comporter. Il suit sa propre morale qui, bien que bienveillante, ne s\'accorde pas forcément avec celle de la société.',
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Alignement.ashx#Chaotique_Bon_2'
		  ),
		  array(
			 'name' => 'Loyal Neutre',
			 'short' => 'LN',
			 'description' => 'Un individu Loyal Neutre est fiable et honorable sans pour autant être fanatique.',
			 'detail' => 'Un personnage Loyal Neutre agit selon la loi, la tradition ou son code de conduite personnel. L\'ordre et l\'organisation représentent tout pour lui. Il se peut qu\'il croit en l\'ordre individuel et vive selon un code ou une règle ou qu\'il croit en l\'ordre général et privilégie un gouvernement fort et organisé.',
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Alignement.ashx#Loyal_Neutre_3'
		  ),
		  array(
			 'name' => 'Neutre',
			 'short' => 'N',
			 'description' => 'Être Neutre permet d\'agir naturellement en toute situation, sans se laisser guider par ses préjugés ou ses obligations.',
			 'detail' => 'Un personnage neutre fait ce qui lui semble une bonne idée. Il n\'a pas vraiment de préférence lorsqu\'il s\'agit de choisir entre le Bien et le Mal ou entre la Loi et le Chaos (c\'est ainsi que le personnage Neutre est parfois qualifié de « Neutre absolu »). Dans la plupart des cas, la neutralité représente une absence de convictions plutôt qu\'un véritable dévouement envers la neutralité. Le personnage aurait ainsi plutôt tendance à penser que le Bien vaut mieux que le Mal, car il préfère que ses voisins et ses dirigeants politiques se montrent bienveillants plutôt que malveillants. Cela étant, il ne se sent nullement obligé de défendre la cause du Bien, ni en pratique ni en théorie.<br />
<br/>
En revanche, chez certains, la neutralité est un choix philosophique. Pour eux, le Bien, le Mal, la Loi et le Chaos sont partiaux et représentent un danger, comme tous les extrêmes. Ils prônent donc l\'équilibre, qui leur paraît être le meilleur choix à long terme.',
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Alignement.ashx#Neutre_4'
		  ),
		  array(
			 'name' => 'Chaotique Neutre',
			 'short' => 'CN',
			 'description' => 'Être Chaotique Neutre permet de profiter de la véritable liberté, celle qui ne suit pas les restrictions imposées par la société, et n\'oblige pas à faire le bien à tout prix.',
			 'detail' => 'Un personnage Chaotique Neutre agit comme bon lui semble. C\'est avant tout un individualiste. Il accorde une immense valeur à sa liberté mais il ne cherche pas à protéger celle des autres. Il évite l\'autorité, déteste les restrictions et remet toujours la tradition en question. Sa lutte contre la société organisée n\'est pas motivée par un désir d\'anarchie car cette volonté devrait s\'accompagner d\'idées nobles (libérer les opprimés du joug de l\'autorité) ou mauvaises (faire souffrir ceux qui sont différents de lui). Le personnage est parfois imprévisible mais son comportement n\'est pas complètement aléatoire. Il est nettement plus probable qu\'il traverse un pont plutôt qu\'il en saute.',
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Alignement.ashx#Chaotique_Neutre_5'
		  ),
		  array(
			 'name' => 'Loyal Mauvais',
			 'short' => 'LM',
			 'description' => 'L\'alignement Loyal Mauvais représente un Mal méthodique, intentionnel et organisé.',
			 'detail' => 'Un individu Loyal Mauvais prend tout ce qu\'il désire, dans les limites de son code de conduite sans se soucier de ceux à qui il peut faire du mal. Pour lui, les traditions, la loyauté et l\'obéissance ont de l\'importance, mais pas la liberté ni la dignité ou la vie. Il suit les règles existantes, mais ne montre ni pitié ni compassion. Il accepte la hiérarchie, et, même s\'il préfère diriger, il est prêt à obéir. Il condamne les autres, non pas en fonction de leurs actes, mais en fonction de leur race, de leur religion, de leur nationalité ou de leur rang social. Il répugne à violer la Loi ou à trahir sa parole.<br />
<br />
Cette répugnance lui vient en partie de sa nature et en partie de sa dépendance vis à vis l\'ordre établi pour se protéger de ceux qui s\'opposent à lui sur des questions d\'ordre moral. Certains Loyaux Mauvais se fixent eux-mêmes des limites, telles que ne jamais tuer de sang-froid (ils chargent leurs sbires de le faire à leur place) ou ne pas maltraiter les enfants (sauf lorsqu\'il est impossible de faire autrement). Ils pensent que ces règles de conduite les placent au-dessus des scélérats sans scrupules.<br />
<br />
Il arrive que des individus ou des créatures se dévouent au mal avec le même zèle que les croisés des forces du Bien. En plus de nuire aux autres par intérêt, ils prennent plaisir à promouvoir la cause du Mal. Il arrive qu\'ils fassent le mal pour servir leur dieu ou leur maître.',
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Alignement.ashx#Loyal_Mauvais_6'
		  ),
		  array(
			 'name' => 'Neutre Mauvais',
			 'short' => 'NM',
			 'description' => 'L\'alignement Neutre Mauvais représente le Mal à l\'état brut, sans honneur ni nuance.',
			 'detail' => 'Un individu Neutre Mauvais fait tout ce qu\'il veut tant qu\'il peut s\'en tirer. Il ne pense tout simplement qu\'à lui. Il se moque de tuer des gens par profit, pour le plaisir, ou parce que cela l\'arrange. Il n\'apprécie pas particulièrement l\'ordre et pense que le respect de la Loi, d\'un code de conduite ou des traditions ne le rendra pas meilleur ou plus noble. Il ne montre pas une nature agitée et n\'est pas pour la recherche de conflits caractéristique des êtres Chaotiques Mauvais.<br />
<br />
Certains individus Neutres Mauvais érigent le Mal en idéal et s\'y dévouent corps et âme. La plupart du temps, ils se consacrent à un dieu ou à une société secrète maléfique.',
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Alignement.ashx#Neutre_Mauvais_7'
		  ),
		  array(
			 'name' => 'Chaotique Mauvais',
			 'short' => 'CM',
			 'description' => 'Les êtres Chaotiques Mauvais représentent la destruction, non seulement de la beauté et de la vie, mais aussi de l\'ordre sur lequel cette beauté et cette vie s\'appuient.',
			 'detail' => 'Un individu Chaotique Mauvais suit sa cupidité, sa haine et sa soif de destruction. Il s\'énerve facilement, il est sadique, violent et complètement imprévisible. S\'il veut quelque chose pour lui, il se montre simplement brutal et impitoyable mais s\'il s\'est donné pour objectif de répandre le Mal et le Chaos, c\'est encore pire. Fort heureusement, ses plans sont désorganisés et les groupes qu\'il constitue ou auxquels il se joint sont très mal structurés. La plupart du temps, les êtres Chaotiques Mauvais ne coopèrent que sous la menace et leur chef reste place uniquement tant qu\'il survit aux tentatives visant à le renverser ou l\'assassiner.',
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Alignement.ashx#Chaotique_Mauvais_8'
		  ),
	   );

	   foreach ($alignments as $data) {
		  $alignment = new Alignment();
		  $alignment->setName($data['name']);
		  $alignment->setShort($data['short']);
		  $alignment->setDescription($data['description']);
		  $alignment->setDetail($data['detail']);
		  
		  $d = parse_url($data['link']);
		  $source = $this->container->get('doctrine')
				->getRepository('IcoRulesBundle:LinkSource')
				->findOneByDomain($d['host']);
		  $link = new Link();
		  $link->setSource($source);
		  $link->setUrl($data['link']);
		  $alignment->setLink($link);
		  $manager->persist($alignment);
	   }
	   $manager->flush();
    }

    public function getOrder() {
	   return 16;
    }
}
