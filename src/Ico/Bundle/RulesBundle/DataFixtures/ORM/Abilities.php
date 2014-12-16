<?php

namespace Kiwi\Bundle\TrainingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ico\Bundle\RulesBundle\Entity\Ability;
use Ico\Bundle\RulesBundle\Entity\Link;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Abilities implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {
    
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
	   
	   $abilities = array(
		  array(
			 'name' => 'Force',
			 'short' => 'For',
			 'description' => 'La Force représente la puissance musculaire et physique.',
			 'detail' => '<i>La Force représente la puissance musculaire et physique.</i><br><br>Cette caractéristique est importante pour les combattants au corps à corps comme les <a class="pagelink" href="Pathfinder-RPG.guerrier.ashx" title="Le guerrier">guerriers</a>, les <a class="pagelink" href="Pathfinder-RPG.moine.ashx" title="Le moine">moines</a>, les <a class="pagelink" href="Pathfinder-RPG.paladin.ashx" title="Le paladin">paladins</a> et certains <a class="pagelink" href="Pathfinder-RPG.r%c3%b4deur.ashx" title="Le rôdeur">rôdeurs</a>. La Force indique également le <a class="pagelink" href="Pathfinder-RPG.encombrement.ashx" title="Encombrement">poids maximal</a> que votre personnage peut porter. Un personnage avec une valeur de Force de 0 est trop faible pour se mouvoir ; il est <a class="pagelink" href="Pathfinder-RPG.inconscient.ashx" title="Inconscient">inconscient</a>. Certaines créatures ne possèdent pas de valeur de Force et n\'appliquent aucun modificateur aux <a class="pagelink" href="Pathfinder-RPG.comp%c3%a9tences.ashx" title="Les compétences">compétences</a> et aux jets basés sur la Force.<br><br>On applique le modificateur de Force
<ul><li>aux jets d\'<a class="pagelink" href="Pathfinder-RPG.attaque%20au%20corps%20%c3%a0%20corps.ashx" title="attaque au corps à corps">attaque au corps à corps</a>.</li><li>aux <a class="pagelink" href="Pathfinder-RPG.jet%20de%20d%c3%a9g%c3%a2ts.ashx" title="jet de dégâts">jets de dégâts</a> lorsque vous utilisez une <a class="pagelink" href="Pathfinder-RPG.arme%20de%20corps%20%c3%a0%20corps.ashx" title="arme de corps à corps">arme de corps à corps</a> ou une <a class="pagelink" href="Pathfinder-RPG.arme%20de%20jet.ashx" title="arme de jet">arme de jet</a>, y compris une fronde (avec des exceptions : les attaques portées avec la main secondaire ne bénéficient que de la moitié du bonus de Force du personnage et les attaques à deux mains reçoivent une fois et demie le bonus de Force. Les malus de Force – mais pas les bonus – s\'appliquent aux jets d\'attaque lorsqu\'on utilise un arc qui n\'est pas un arc composite).</li><li>aux tests d\'<a class="pagelink" href="Pathfinder-RPG.Escalade.ashx" title="Escalade">Escalade</a> et de <a class="pagelink" href="Pathfinder-RPG.Natation.ashx" title="Natation">Natation</a>.</li><li>aux tests de Force (pour forcer une porte par exemple).<br></li></ul>',
			 'mental' => false,
			 'applied' => "aux jets d'attaque au corps à corps, aux jets de dégâts lorsque vous utilisez une arme de corps à corps ou une arme de jet, aux tests d'Escalade et de Natation, aux tests de Force",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Caract%C3%A9ristiques.ashx#FORCE'
		  ),
		  array(
			 'name' => 'Dextérité',
			 'short' => 'Dex',
			 'description' => 'La Dextérité représente l\'agilité, les réflexes et l\'équilibre.',
			 'detail' => '<i>La Dextérité représente l\'agilité, les réflexes et l\'équilibre.</i><br><br>Cette caractéristique est surtout importante pour les <a class="pagelink" href="Pathfinder-RPG.roublard.ashx" title="Le roublard">roublards</a> mais elle est également utile pour les personnages qui ne portent que des <a class="pagelink" href="Pathfinder-RPG.armure%20l%c3%a9g%c3%a8re.ashx" title="armure légère">armures légères</a> ou <a class="pagelink" href="Pathfinder-RPG.armure%20interm%c3%a9diaire.ashx" title="armure intermédiaire">intermédiaires</a> ou aucune armure du tout. C\'est une caractéristique vitale pour les personnages qui désirent exceller au combat avec des <a class="pagelink" href="Pathfinder-RPG.arme%20%c3%a0%20distance.ashx" title="arme à distance">armes à distance</a> comme les arcs et les frondes. Un personnage avec une valeur de Dextérité de 0 est incapable de se mouvoir ; il est immobile (mais pas inconscient).<br><br>On applique le modificateur de Dextérité
<ul><li>aux jets d\'<a class="pagelink" href="Pathfinder-RPG.attaque%20%c3%a0%20distance.ashx" title="Attaque à distance">attaque à distance</a> ; par exemple pour les attaques à l\'arbalète, à l\'arc, à la hache de lancer ou encore pour de nombreux sorts d\'attaque à distance comme <i><a class="pagelink" href="Pathfinder-RPG.rayon%20ardent.ashx" title="Rayon ardent">rayon ardent</a></i> ou <i><a class="pagelink" href="Pathfinder-RPG.lumi%c3%a8re%20br%c3%bblante.ashx" title="Lumière brûlante">lumière brûlante</a></i>.</li><li>à la <a class="pagelink" href="Pathfinder-RPG.CA.ashx" title="CA">classe d\'armure</a> (CA), pour autant que le personnage puisse réagir à l\'attaque.</li><li>aux jets de <a class="pagelink" href="Pathfinder-RPG.R%c3%a9flexes.ashx" title="Réflexes">Réflexes</a> pour éviter les <i><a class="pagelink" href="Pathfinder-RPG.boule%20de%20feu.ashx" title="Boule de feu">boules de feu</a></i> et d\'autres attaques auxquelles on peut échapper en se déplaçant rapidement.</li><li>aux tests d\'<a class="pagelink" href="Pathfinder-RPG.Acrobaties.ashx" title="Acrobaties">Acrobaties</a>, de <a class="pagelink" href="Pathfinder-RPG.Sabotage.ashx" title="Sabotage">Sabotage</a>, de <a class="pagelink" href="Pathfinder-RPG.Discr%c3%a9tion.ashx" title="Discrétion">Discrétion</a>, d\'<a class="pagelink" href="Pathfinder-RPG.%c3%89quitation.ashx" title="Équitation">Équitation</a>, d\'<a class="pagelink" href="Pathfinder-RPG.Escamotage.ashx" title="Escamotage">Escamotage</a>, d\'<a class="pagelink" href="Pathfinder-RPG.%c3%89vasion.ashx" title="Évasion">Évasion</a> et de <a class="pagelink" href="Pathfinder-RPG.Vol.ashx" title="Vol">Vol</a>.<br></li></ul>',
			 'mental' => false,
			 'applied' => "aux jets d'attaque à distance, à la classe d'armure (CA), aux jets de Réflexes, aux tests d'Acrobaties, de Sabotage, de Discrétion, d'Équitation, d'Escamotage, d'Évasion et de Vol",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Caract%C3%A9ristiques.ashx#DEXTERITE'
		  ),
		  array(
			 'name' => 'Constitution',
			 'short' => 'Con',
			 'description' => 'La Constitution représente la santé et l\'endurance de votre personnage.',
			 'detail' => '<i>La Constitution représente la santé et l\'endurance de votre personnage.</i><br><br>Le bonus lié à la Constitution augmente les <a class="pagelink" href="Pathfinder-RPG.point%20de%20vie.ashx" title="point de vie">points de vie</a> du personnage, ce qui rend cette caractéristique importante pour toutes les <a class="pagelink" href="Pathfinder-RPG.classes.ashx" title="Les classes">classes</a>. Certaines créatures, comme les <a class="pagelink" href="Pathfinder-RPG.type%20mort-vivant.ashx" title="Mort-vivant">morts-vivants</a> et les <a class="pagelink" href="Pathfinder-RPG.type%20cr%c3%a9ature%20artificielle.ashx" title="Créature artificielle">créatures artificielles</a>, ne possèdent pas de valeur de Constitution. Leur modificateur pour tous les jets basés sur la Constitution est de +0. Un personnage avec une valeur de Constitution de 0 est <a class="pagelink" href="Pathfinder-RPG.mort.ashx" title="Mort">mort</a>.<br><br>On applique le modificateur de Constitution
<ul><li>à chacun des <a class="pagelink" href="Pathfinder-RPG.DV.ashx" title="DV">dés de vie</a> (un malus ne peut jamais abaisser le résultat du dé en dessous de 1 cependant : un personnage gagne toujours au moins 1 point de vie chaque fois qu\'il gagne un niveau).</li><li>aux jets de <a class="pagelink" href="Pathfinder-RPG.Vigueur.ashx" title="Vigueur">Vigueur</a>, pour résister aux <a class="pagelink" href="Pathfinder-RPG.poison.ashx" title="poison">poisons</a>, aux <a class="pagelink" href="Pathfinder-RPG.maladie.ashx" title="maladie">maladies</a> et aux autres menaces du même genre.<br></li></ul><br>Si la valeur de Constitution d\'un personnage change suffisamment pour que son modificateur de Constitution soit altéré, les <a class="pagelink" href="Pathfinder-RPG.point%20de%20vie.ashx" title="point de vie">points de vie</a> du personnage sont modifiés en conséquence (vers le haut ou vers le bas).',
			 'mental' => false,
			 'applied' => "à chacun des dés de vie, aux jets de Vigueur",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Caract%C3%A9ristiques.ashx#CONSTITUTION'
		  ),
		  array(
			 'name' => 'Intelligence',
			 'short' => 'Int',
			 'description' => 'L\'Intelligence détermine la capacité d\'apprentissage et de raisonnement de votre personnage.',
			 'detail' => '<i>L\'Intelligence détermine la capacité d\'apprentissage et de raisonnement de votre personnage.</i><br><br>Cette caractéristique est importante pour les <a class="pagelink" href="Pathfinder-RPG.magicien.ashx" title="Le magicien">magiciens</a> car elle influence leur aptitude à lancer des <a class="pagelink" href="Pathfinder-RPG.sort.ashx" title="sort">sorts</a> de nombreuses manières. L\'instinct animal correspond à une Intelligence de 1 ou 2 ; les créatures qui peuvent comprendre un langage parlé possèdent une Intelligence d\'au moins 3. Un personnage avec une valeur d\'Intelligence de 0 est comateux. Certaines créatures ne possèdent pas de valeur d\'Intelligence ; leur modificateur pour les compétences et les jets basés sur l\'Intelligence est de +0.<br><br>On applique le modificateur d\'Intelligence
<ul><li>au nombre de <a class="pagelink" href="Pathfinder-RPG.Linguistique.ashx" title="Linguistique">langues supplémentaires</a> que le personnage connaît lorsqu\'il entre en jeu. Ces langues viennent s\'ajouter aux langues <a class="pagelink" href="Pathfinder-RPG.races.ashx" title="Les races des personnages">raciales</a> initiales et au langage commun que le personnage connaît automatiquement. Les créatures qui possèdent un malus d\'Intelligence restent quand même capables de lire et d\'écrire leurs langues raciales, pour autant qu\'elles possèdent une valeur d\'Intelligence d\'au moins 3.</li><li>au nombre de <a class="pagelink" href="Pathfinder-RPG.rang.ashx" title="rang">rangs</a> de <a class="pagelink" href="Pathfinder-RPG.comp%c3%a9tences.ashx" title="Les compétences">compétence</a> gagnés à chaque <a class="pagelink" href="Pathfinder-RPG.niveau.ashx" title="niveau">niveau</a> (sans toutefois abaisser celui-ci en dessous de 1).</li><li>aux tests d\'<a class="pagelink" href="Pathfinder-RPG.Art%20de%20la%20magie.ashx" title="Art de la magie">Art de la magie</a>, d\'<a class="pagelink" href="Pathfinder-RPG.Artisanat.ashx" title="Artisanat">Artisanat</a>, de <a class="pagelink" href="Pathfinder-RPG.Connaissances.ashx" title="Connaissances">Connaissances</a>, d\'<a class="pagelink" href="Pathfinder-RPG.Estimation.ashx" title="Estimation">Estimation</a> et de <a class="pagelink" href="Pathfinder-RPG.Linguistique.ashx" title="Linguistique">Linguistique</a>.<br></li></ul><br>L\'Intelligence des <a class="pagelink" href="Pathfinder-RPG.magicien.ashx" title="Le magicien">magiciens</a>, des <a class="pagelink" href="Pathfinder-RPG.alchimiste.ashx" title="L\'alchimiste">alchimistes</a>, des <a class="pagelink" href="Pathfinder-RPG.sorci%c3%a8re.ashx" title="La sorcière">sorcières</a> et des <a class="pagelink" href="Pathfinder-RPG.magus.ashx" title="Le Magus">magus</a> détermine le nombre de sorts en bonus qu\'ils obtiennent. Pour pouvoir lancer un sort donné, le <a class="pagelink" href="Pathfinder-RPG.magicien.ashx" title="Le magicien">magicien</a> doit posséder une valeur d\'<a class="pagelink" href="Pathfinder-RPG.Intelligence.ashx" title="L\'Intelligence">Intelligence</a> d\'au moins 10 + le <a class="pagelink" href="Pathfinder-RPG.niveau%20de%20sort.ashx" title="Niveau de sort">niveau du sort</a>.',
			 'mental' => true,
			 'applied' => "au nombre de langues supplémentaires, au nombre de rangs de compétence gagnés à chaque niveau, aux tests d'Art de la magie, d'Artisanat, de Connaissances, d'Estimation et de Linguistique",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Caract%C3%A9ristiques.ashx#INTELLIGENCE'
		  ),
		  array(
			 'name' => 'Sagesse',
			 'short' => 'Sag',
			 'description' => 'La Sagesse mesure la volonté, le bon sens, la capacité de percevoir et l\'intuition du personnage.',
			 'detail' => '<i>La Sagesse mesure la volonté, le bon sens, la capacité de percevoir et l\'intuition du personnage.</i><br /><br />C\'est une caractéristique essentielle pour les <a class="pagelink" href="Pathfinder-RPG.pr%c3%aatre.ashx" title="Le prêtre">prêtres</a> et les <a class="pagelink" href="Pathfinder-RPG.druide.ashx" title="Le druide">druides</a> et importante pour les <a class="pagelink" href="Pathfinder-RPG.paladin.ashx" title="Le paladin">paladins</a>, les <a class="pagelink" href="Pathfinder-RPG.r%c3%b4deur.ashx" title="Le rôdeur">rôdeurs</a> et les <a class="pagelink" href="Pathfinder-RPG.inquisiteur.ashx" title="L&#39;inquisiteur">inquisiteurs</a>. Placez une valeur élevée en Sagesse si vous voulez que votre personnage possède des sens aiguisés. Toutes les créatures possèdent une valeur de Sagesse. Un personnage avec une valeur de Sagesse de 0 est incapable de penser de manière rationnelle ; il est <a class="pagelink" href="Pathfinder-RPG.inconscient.ashx" title="Inconscient">inconscient</a>.<br /><br />On applique le modificateur de Sagesse
<ul><li>aux jets de <a class="pagelink" href="Pathfinder-RPG.Volont%c3%a9.ashx" title="Volonté">Volonté</a> (pour contrer les effets de sorts tels que <i><a class="pagelink" href="Pathfinder-RPG.charme-personne.ashx" title="Charme-personne">charme-personne</a></i>).</li><li>aux tests de <a class="pagelink" href="Pathfinder-RPG.Perception.ashx" title="Perception">Perception</a>, de <a class="pagelink" href="Pathfinder-RPG.Premiers%20secours.ashx" title="Premiers secours">Premiers secours</a>, de <a class="pagelink" href="Pathfinder-RPG.Profession.ashx" title="Profession">Profession</a>, de <a class="pagelink" href="Pathfinder-RPG.Psychologie.ashx" title="Psychologie">Psychologie</a> et de <a class="pagelink" href="Pathfinder-RPG.Survie.ashx" title="Survie">Survie</a>.<br /></li></ul><br />La Sagesse des <a class="pagelink" href="Pathfinder-RPG.pr%c3%aatre.ashx" title="Le prêtre">prêtres</a>, <a class="pagelink" href="Pathfinder-RPG.druide.ashx" title="Le druide">druides</a> et <a class="pagelink" href="Pathfinder-RPG.r%c3%b4deur.ashx" title="Le rôdeur">rôdeurs</a> détermine le nombre de sorts en bonus qu\'ils obtiennent. Pour pouvoir lancer un sort donné, un <a class="pagelink" href="Pathfinder-RPG.pr%c3%aatre.ashx" title="Le prêtre">prêtre</a>, <a class="pagelink" href="Pathfinder-RPG.druide.ashx" title="Le druide">druide</a> ou <a class="pagelink" href="Pathfinder-RPG.r%c3%b4deur.ashx" title="Le rôdeur">rôdeur</a> doit posséder une valeur de Sagesse d\'au moins 10 + le <a class="pagelink" href="Pathfinder-RPG.niveau%20de%20sort.ashx" title="Niveau de sort">niveau du sort</a>.',
			 'mental' => true,
			 'applied' => "aux jets de Volonté, aux tests de Perception, de Premiers secours, de Profession, de Psychologie et de Survie",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Caract%C3%A9ristiques.ashx#SAGESSE'
		  ),
		  array(
			 'name' => 'Charisme',
			 'short' => 'Cha',
			 'description' => 'Le Charisme représente la personnalité, le magnétisme personnel, la capacité à diriger et l\'apparence du personnage.',
			 'detail' => '<i>Le Charisme représente la personnalité, le magnétisme personnel, la capacité à diriger et l\'apparence du personnage.</i><br /><br />C\'est une caractéristique essentielle pour les <a class="pagelink" href="Pathfinder-RPG.paladin.ashx" title="Le paladin">paladins</a>, les <a class="pagelink" href="Pathfinder-RPG.ensorceleur.ashx" title="L&#39;ensorceleur">ensorceleurs</a> et les <a class="pagelink" href="Pathfinder-RPG.barde.ashx" title="Le barde">bardes</a>, et importante pour les <a class="pagelink" href="Pathfinder-RPG.pr%c3%aatre.ashx" title="Le prêtre">prêtres</a> (car elle conditionne leur capacité à <a class="pagelink" href="Pathfinder-RPG.canalisation%20d%c3%a9nergie.ashx" title="canalisation d&#39;énergie">canaliser de l\'énergie</a>). Dans le cas des créatures <a class="pagelink" href="Pathfinder-RPG.type%20mort-vivant.ashx" title="Mort-vivant">mortes-vivantes</a>, le Charisme représente la force vitale surnaturelle qui les anime. Toutes les créatures possèdent une valeur de Charisme. Un personnage avec une valeur de Charisme de 0 est incapable de prendre la décision de faire quoi que ce soit ; il est <a class="pagelink" href="Pathfinder-RPG.inconscient.ashx" title="Inconscient">inconscient</a>.<br /><br />On applique le modificateur de Charisme
<ul><li>aux tests de <a class="pagelink" href="Pathfinder-RPG.Bluff.ashx" title="Bluff">Bluff</a>, de <a class="pagelink" href="Pathfinder-RPG.D%c3%a9guisement.ashx" title="Déguisement">Déguisement</a>, de <a class="pagelink" href="Pathfinder-RPG.Diplomatie.ashx" title="Diplomatie">Diplomatie</a>, de <a class="pagelink" href="Pathfinder-RPG.Dressage.ashx" title="Dressage">Dressage</a>, d\'<a class="pagelink" href="Pathfinder-RPG.Intimidation.ashx" title="Intimidation">Intimidation</a>, de <a class="pagelink" href="Pathfinder-RPG.Repr%c3%a9sentation.ashx" title="Représentation">Représentation</a> et d\'<a class="pagelink" href="Pathfinder-RPG.Utilisation%20dobjets%20magiques.ashx" title="Utilisation d&#39;objets magiques">Utilisation d\'objets magiques</a>.</li><li>aux jets relatifs à des tentatives pour influencer les autres.</li><li>au DD des <a class="pagelink" href="Pathfinder-RPG.canalisation%20d%c3%a9nergie.ashx" title="canalisation d&#39;énergie">canalisations d\'énergie</a> des <a class="pagelink" href="Pathfinder-RPG.pr%c3%aatre.ashx" title="Le prêtre">prêtres</a> et des <a class="pagelink" href="Pathfinder-RPG.paladin.ashx" title="Le paladin">paladins</a> tentant de blesser leurs ennemis <a class="pagelink" href="Pathfinder-RPG.type%20mort-vivant.ashx" title="Mort-vivant">morts-vivants</a>.<br /></li></ul><br />Le Charisme des <a class="pagelink" href="Pathfinder-RPG.barde.ashx" title="Le barde">bardes</a>, <a class="pagelink" href="Pathfinder-RPG.paladin.ashx" title="Le paladin">paladins</a>, <a class="pagelink" href="Pathfinder-RPG.ensorceleur.ashx" title="L&#39;ensorceleur">ensorceleurs</a> et des <a class="pagelink" href="Pathfinder-RPG.conjurateur.ashx" title="Le conjurateur (aussi appelé invocateur)">conjurateurs</a> détermine le nombre de sorts en bonus qu\'ils obtiennent. Pour pouvoir lancer un sort donné, un barde, paladin ou ensorceleur doit posséder une valeur de Charisme d\'au moins 10 + le <a class="pagelink" href="Pathfinder-RPG.niveau%20de%20sort.ashx" title="Niveau de sort">niveau du sort</a>.',
			 'mental' => true,
			 'applied' => "au DD des canalisations d'énergie des prêtres et des paladins, aux jets relatifs à des tentatives pour influencer les autres, aux tests de Bluff, de Déguisement, de Diplomatie, de Dressage, d'Intimidation, de Représentation et d'Utilisation d'objets magiques",
			 'link' => 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Caract%C3%A9ristiques.ashx#CHARISME'
		  ),
	   );

	   foreach ($abilities as $data) {
		  $ability = new Ability();
		  $ability->setName($data['name']);
		  $ability->setShort($data['short']);
		  $ability->setDescription($data['description']);
		  $ability->setDetail($data['detail']);
		  $ability->setMental($data['mental']);
		  
		  $d = parse_url($data['link']);
		  $source = $this->container->get('doctrine')
				->getRepository('IcoRulesBundle:LinkSource')
				->findOneByDomain($d['host']);
		  $link = new Link();
		  $link->setSource($source);
		  $link->setUrl($data['link']);
		  $ability->setLink($link);
		  
		  $ability->setApplied($data['applied']);
		  $manager->persist($ability);
	   }
	   $manager->flush();
    }

    public function getOrder() {
	   return 11;
    }

}
