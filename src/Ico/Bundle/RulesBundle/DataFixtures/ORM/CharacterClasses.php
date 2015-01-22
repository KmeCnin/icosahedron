<?php

namespace Kiwi\Bundle\TrainingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ico\Bundle\RulesBundle\Entity\CharacterClass;
use Ico\Bundle\RulesBundle\Entity\CharacterClassLevel;
use Ico\Bundle\RulesBundle\Entity\CharacterClassSpecial;
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
    public function setContainer(ContainerInterface $container = null) {
	   $this->container = $container;
    }

    public function load(ObjectManager $manager) {
	   
	   $specials = array(
		  array(
			 'nameID' => 'PACTEMAGIQUE',
			 'name' => 'Pacte magique',
			 'description' => 'Un puissant lien se crée entre le magicien et un objet ou une créature.',
			 'detail' => 'Au niveau 1, un puissant lien se crée entre le magicien et un objet ou une créature. Ce lien peut prendre l’une des deux formes suivantes : un <a class="pagelink" href="Pathfinder-RPG.familier.ashx" title="familier">familier</a> ou un objet fétiche. Un familier est un animal de compagnie magique qui améliore les compétences et rehausse les sens du magicien alors qu’un objet fétiche est un objet que le magicien utilise pour lancer des sorts supplémentaires ou en tant qu’objet magique. Une fois qu’un magicien a choisi une de ces deux options, il ne peut plus modifier son choix. Pour les règles concernant les <a class="pagelink" href="Pathfinder-RPG.familier.ashx" title="familier">familiers</a>, voir la page correspondante, pour celles qui traitent des objets fétiches, voir ci-dessous.<br /><br />Les magiciens qui choisissent un objet fétiche le possèdent automatiquement (sans devoir le payer) lorsqu’ils entrent en jeu. L’objet en question doit appartenir à une des catégories suivantes : amulette, anneau, arme, baguette ou bâton. Il s’agit toujours d’un objet de maître. Les armes que le personnage reçoit au niveau 1 ne sont jamais composées d’un matériel spécial. Si l’objet est une amulette ou un anneau, il doit être porté pour pouvoir être utilisé. Les armes, les baguettes et les bâtons, quant à eux, doivent être tenus dans une main. Si un magicien tente de lancer un sort sans porter ou tenir son objet fétiche, il doit réussir un test de <a class="pagelink" href="Pathfinder-RPG.concentration.ashx" title="Concentration">concentration</a> pour éviter de perdre le sort. Le <a class="pagelink" href="Pathfinder-RPG.DD.ashx" title="DD">DD</a> de ce test vaut 20 + le <a class="pagelink" href="Pathfinder-RPG.niveau%20de%20sort.ashx" title="Niveau de sort">niveau du sort</a>. Si l’objet est un anneau ou une amulette, il occupe <a class="pagelink" href="Pathfinder-RPG.R%c3%a8gles%20relatives%20aux%20objets%20magiques.ashx#SURLECORPS" title="Règles relatives aux objets magiques">l’emplacement d’un objet magique</a> (cou ou anneau).<br /><br />Un magicien peut utiliser son objet fétiche une fois par jour pour lancer n’importe quel sort qui se trouve dans son <a class="pagelink" href="Pathfinder-RPG.magicien.ashx#GRIMOIRE" title="Le magicien">grimoire</a> et qu’il est capable de lancer et ce, même s’il ne l’a pas préparé. Ce sort fonctionne comme n’importe quel autre sort lancé par le magicien : même temps d’incantation, même durée et les effets dépendant du niveau du magicien sont déterminés normalement. Le sort ne peut être modifié par aucun <a class="pagelink" href="Pathfinder-RPG.Dons.ashx#DONMETAMAGIE" title="Les dons">don de métamagie</a> ni aucune capacité spéciale. Le magicien ne peut pas utiliser son objet fétiche pour lancer des sorts appartenant à ses écoles opposées (voir « <a class="pagelink" href="Pathfinder-RPG.magicien.ashx#ECOLEDEMAGIE" title="Le magicien">École de magie</a> »).<br /><br />Un magicien peut ajouter de nouvelles capacités magiques à son objet fétiche comme s’il possédait les <a class="pagelink" href="Pathfinder-RPG.dons.ashx#DONCREATION" title="Les dons">dons de création d’objets magiques</a> nécessaires, mais seulement si son niveau est suffisant pour remplir les conditions requises par ces dons. Par exemple, un magicien ayant une dague comme objet fétiche doit être de niveau supérieur ou égal à 5 pour ajouter des propriétés magiques à la dague (voir le don de <a class="pagelink" href="Pathfinder-RPG.Cr%c3%a9ation%20darmes%20et%20armures%20magiques.ashx" title="Création d&#39;armes et armures magiques">Création d’armes et d’armures magiques</a>). Si l’objet fétiche est une baguette et qu’on dépense sa dernière charge, il ne peut plus être utilisé comme baguette magique mais il n’est pas détruit pour autant : il conserve ses capacités d’objet fétiche et peut être utilisé pour créer une nouvelle baguette. Les propriétés magiques d’un objet fétiche, y compris les capacités magiques ajoutées à l’objet, ne fonctionnent que pour le magicien qui le possède. Si le propriétaire d’un objet fétiche meurt ou si l’objet est remplacé, il redevient un objet de maître ordinaire.<br /><br />Si un objet fétiche est endommagé, il revient à son maximum de points de vie la prochaine fois que le magicien prépare ses sorts. Si l’objet fétiche est détruit ou perdu, le magicien peut le remplacer une semaine plus tard en réalisant un rituel qui dure huit heures et coûte 200 po par niveau de magicien (en plus du coût de l’objet de maître). Le nouvel objet fétiche ne possède aucune des propriétés magiques qui avaient pu être ajoutées à l’ancien objet. Un magicien peut également désigner un nouvel objet magique comme objet fétiche de remplacement. Cela fonctionne comme ci-dessus, si ce n’est que l’objet magique conserve ses propriétés et acquiert en plus les avantages et les désavantages des objets fétiches.',
		  ),
               array(
			 'nameID' => 'ECOLEDEMAGIE',
			 'name' => 'École de magie',
			 'description' => 'Un magicien peut choisir de se spécialiser dans une école de magie afin d’acquérir des sorts et des pouvoirs supplémentaires associés à cette école.',
			 'detail' => 'Un magicien peut ajouter de nouvelles capacités magiques à son objet fétiche comme s’il possédait les <a class="pagelink" href="Pathfinder-RPG.dons.ashx#DONCREATION" title="Les dons">dons de création d’objets magiques</a> nécessaires, mais seulement si son niveau est suffisant pour remplir les conditions requises par ces dons. Par exemple, un magicien ayant une dague comme objet fétiche doit être de niveau supérieur ou égal à 5 pour ajouter des propriétés magiques à la dague (voir le don de <a class="pagelink" href="Pathfinder-RPG.Cr%c3%a9ation%20darmes%20et%20armures%20magiques.ashx" title="Création d&#39;armes et armures magiques">Création d’armes et d’armures magiques</a>). Si l’objet fétiche est une baguette et qu’on dépense sa dernière charge, il ne peut plus être utilisé comme baguette magique mais il n’est pas détruit pour autant : il conserve ses capacités d’objet fétiche et peut être utilisé pour créer une nouvelle baguette. Les propriétés magiques d’un objet fétiche, y compris les capacités magiques ajoutées à l’objet, ne fonctionnent que pour le magicien qui le possède. Si le propriétaire d’un objet fétiche meurt ou si l’objet est remplacé, il redevient un objet de maître ordinaire.<br /><br />Si un objet fétiche est endommagé, il revient à son maximum de points de vie la prochaine fois que le magicien prépare ses sorts. Si l’objet fétiche est détruit ou perdu, le magicien peut le remplacer une semaine plus tard en réalisant un rituel qui dure huit heures et coûte 200 po par niveau de magicien (en plus du coût de l’objet de maître). Le nouvel objet fétiche ne possède aucune des propriétés magiques qui avaient pu être ajoutées à l’ancien objet. Un magicien peut également désigner un nouvel objet magique comme objet fétiche de remplacement. Cela fonctionne comme ci-dessus, si ce n’est que l’objet magique conserve ses propriétés et acquiert en plus les avantages et les désavantages des objets fétiches.<br /><br /><div class="ref right" style="padding: 0 0 3px 3px;"><a name="ECOLEDEMAGIE" href="#ECOLEDEMAGIE"><img class="opachover" src="/images/pathfinder/wiki/logoref.png" width="12px" style="opacity:0.1"></a></div>
<h3 class="separator">École de magie<a class="headeranchor" id="École_de_magie_4" href="#École_de_magie_4" title="Lien vers cette section">&#0182;</a></h3>
Un magicien peut choisir de se spécialiser dans une <a class="pagelink" href="Pathfinder-RPG.%c3%89coles%20de%20magie.ashx" title="Les écoles de magie">école de magie</a> afin d’acquérir des sorts et des pouvoirs supplémentaires associés à cette école. Ce choix doit être fait au niveau 1 et ne peut être modifié par la suite. Si le magicien ne choisit aucune école, il reçoit les avantages liés à l’<a class="pagelink" href="Pathfinder-RPG.%c3%89coles%20de%20magie.ashx#ECOLEUNIVERSELLE" title="Les écoles de magie">école universelle</a>.<br /><br />Un magicien qui choisit de se spécialiser dans une des huit <a class="pagelink" href="Pathfinder-RPG.%c3%89coles%20de%20magie.ashx" title="Les écoles de magie">écoles de magie</a> standard doit sélectionner deux autres écoles qui deviennent ses écoles opposées et représentent les domaines de connaissances qu’il décide de sacrifier pour se concentrer sur son domaine de prédilection. Un magicien peut préparer un sort appartenant à une de ses écoles opposées mais il doit alors utiliser deux <a class="pagelink" href="Pathfinder-RPG.emplacement%20de%20sort.ashx" title="emplacement de sort">emplacements de sort</a> du même niveau.<br /><br /><i>Par exemple, un magicien dont une des écoles d’opposition est l’<a class="pagelink" href="Pathfinder-RPG.%c3%89coles%20de%20magie.ashx#EVOCATION" title="Les écoles de magie">Évocation</a> doit utiliser deux emplacements de sort de 3e niveau pour préparer une </i><a class="pagelink" href="Pathfinder-RPG.boule%20de%20feu.ashx" title="Boule de feu">boule de feu</a><i>. De plus, le spécialiste subit un malus de -4 à tous les tests de compétence pour <a class="pagelink" href="Pathfinder-RPG.cr%c3%a9ation%20dobjets%20magiques.ashx" title="Création d&#39;objets magiques">fabriquer un objet magique</a> dont la création nécessite un sort appartenant à une de ses écoles d’opposition.</i><br /><br />Un magicien généraliste peut préparer des sorts de n’importe quelle école sans aucune restriction.<br /><br />Les magiciens spécialistes reçoivent un certain nombre de pouvoirs d’école dépendant de leur spécialité. Ils obtiennent également un <a class="pagelink" href="Pathfinder-RPG.emplacement%20de%20sort.ashx" title="emplacement de sort">emplacement de sort</a> supplémentaire pour chacun des niveaux de sorts auxquels ils ont accès (sauf le niveau 0). Chaque jour, le magicien peut utiliser cet emplacement supplémentaire pour préparer un sort appartenant à son école de spécialisation et figurant sur son <a class="pagelink" href="Pathfinder-RPG.magicien.ashx#GRIMOIRE" title="Le magicien">grimoire</a>. Le magicien peut choisir de préparer un sort modifié par un <a class="pagelink" href="Pathfinder-RPG.Dons.ashx#DONMETAMAGIE" title="Les dons">don de métamagie</a> dans un de ces emplacements supplémentaires mais il devra alors utiliser un emplacement de niveau plus élevé. Les magiciens généralistes ne reçoivent pas d’emplacements de sort supplémentaires.<br /><br /><div style="float:right; padding: 4px 4px 8px 8px;">
<img title="Advanced Player\'s Guide/Manuel du joueur - règles avancées" class="opachover" src="http://www.pathfinder-fr.org/Wiki/public/Upload/Illustrations/Logos/logoAPG.png" style="opacity: 0.7" />
</div>Au lieu de se spécialiser dans l’une des huit écoles de magie standard, un magicien peut se focaliser sur l’étude d’une des quatre écoles de magie élémentaires. Comme les écoles ordinaires, ces quatre nouvelles options octroient un certain nombre de pouvoirs d’école et un emplacement de sort en bonus pour chaque niveau de sorts auquel le magicien a accès (à partir du 1<sup>er</sup> niveau). Contrairement aux écoles ordinaires, une école élémentaire impose au magicien de choisir son élément opposé comme école d’opposition (l’Air contre la Terre, l’Eau contre le Feu). Le magicien ne doit pas choisir de seconde école d’opposition. Pour pouvoir préparer un sort appartenant à son école d’opposition, il doit utiliser deux emplacements de sort, conformément aux règles normales.<br /><br />Voir la <a class="pagelink" href="Pathfinder-RPG.%c3%89coles%20de%20magie.ashx" title="Les écoles de magie">liste des écoles de magie</a>.<br /><br /><div class="ref right" style="padding: 0 0 3px 3px;"><a name="TOURSDEMAGIE" href="#TOURSDEMAGIE"><img class="opachover" src="/images/pathfinder/wiki/logoref.png" width="12px" style="opacity:0.1"></a></div>',
		  ),
               array(
			 'nameID' => 'TOURSDEMAGIE',
			 'name' => 'Tours de magie',
			 'description' => 'Le magicien peut préparer un certain nombre de tours de magie chaque jour.',
			 'detail' => 'Le magicien peut préparer un certain nombre de tours de magie (ou sorts de niveau 0) chaque jour, comme indiqué dans la Table <a class="pagelink" href="Pathfinder-RPG.Magicien.ashx#TABLEMAGICIEN" title="Le magicien">ci-dessus</a> sous la mention « Sorts par jour ». Il jette ces sorts comme les autres mais ils ne sont pas dépensés lorsqu’ils sont lancés et peuvent être utilisés à nouveau.',
		  ),
               array(
			 'nameID' => 'ECRITUREDEPARCHEMINS',
			 'name' => 'Écriture de parchemins',
			 'description' => 'Un magicien de niveau 1 acquiert automatiquement le don Écriture de parchemins comme don supplémentaire.',
			 'detail' => 'Un magicien de niveau 1 acquiert automatiquement le don <a class="pagelink" href="Pathfinder-RPG.%c3%89criture%20de%20parchemins.ashx" title="Écriture de parchemins">Écriture de parchemins</a> comme don supplémentaire.',
		  ),
               array(
			 'nameID' => 'DONSUPPLEMENTAIRE',
			 'name' => 'Dons supplémentaires et découvertes arcaniques',
			 'description' => 'Aux niveaux 5, 10, 15 et 20, le magicien gagne un don supplémentaire (don de métamagie, don de création d’objets ou encore le don Maîtrise des sorts).',
			 'detail' => 'Aux niveaux 5, 10, 15 et 20, le magicien gagne un don supplémentaire. Ce don doit obligatoirement être un <a class="pagelink" href="Pathfinder-RPG.Dons.ashx#DONMETAMAGIE" title="Les dons">don de métamagie</a>, un <a class="pagelink" href="Pathfinder-RPG.Dons.ashx#DONCREATION" title="Les dons">don de création d’objets</a> ou encore le don <a class="pagelink" href="Pathfinder-RPG.Ma%c3%aetrise%20des%20sorts.ashx" title="Maîtrise des sorts">Maîtrise des sorts</a>. Le magicien doit satisfaire à toutes les conditions requises pour le don choisi, y compris le <a class="pagelink" href="Pathfinder-RPG.NLS.ashx" title="NLS">niveau de lanceur de sorts</a> minimum. Ces dons viennent s’ajouter à ceux que tous les personnages gagnent en montant de niveau (et pour lesquels le magicien n’est pas limité aux catégories de dons citées plus haut).<br /><br /><div style="float:right; padding: 4px 4px 8px 8px;">
<img title="Ultimate Magic - Art de la Magie" class="opachover" src="http://www.pathfinder-fr.org/Wiki/public/Upload/Illustrations/Logos/logoUM.png" style="opacity: 0.7" />
</div>Les magiciens passent une grande partie de leur existence à chercher de grandes vérités et à traquer les connaissances comme si leur vie en dépendait. Le pouvoir du magicien ne réside pas forcément dans ses sorts, ce ne sont que des manifestations extérieures visibles de ce pouvoir. La véritable puissance du magicien réside dans son intelligence indomptable, dans sa dévotion à son art et dans ses capacités à dépasser les vérités superficielles pour comprendre les fondements cachés de l’existence. Un magicien passe une grande partie de son temps à faire des recherches sur les sorts et préfère découvrir une bibliothèque inconnue plutôt qu’une salle pleine de pièces d’or. Les magiciens ne sont pas forcément des rats de bibliothèque reclus mais ils brûlent de curiosité face à l’inconnu. Les <a class="pagelink" href="Pathfinder-RPG.d%c3%a9couvertes%20arcaniques.ashx" title="Découvertes arcaniques">découvertes arcaniques</a> résultent de cette obsession pour la magie. Le magicien peut apprendre une découverte magique au lieu de choisir un don normal ou un don de magicien supplémentaire.',
		  ),
	   );

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
			 'baseSkillPoints' => 2,
			 'levels' => array(
				1 => array(
				    'bba' => 0,
				    'ref' => 0,
				    'vig' => 0,
				    'vol' => 2,
				    'specials' => array(
					   'PACTEMAGIQUE' => 'pacte magique',
					   'ECOLEDEMAGIE' => 'école de magie',
					   'TOURSDEMAGIE' => 'tours de magie',
					   'ECRITUREDEPARCHEMINS' => 'écriture de parchemins',
				    ),
				    'dailySpells' => array(3, 1, 0, 0, 0, 0, 0, 0, 0, 0),
				),
				2 => array(
				    'bba' => 1,
				    'ref' => 0,
				    'vig' => 0,
				    'vol' => 3,
				    'dailySpells' => array(4, 2, 0, 0, 0, 0, 0, 0, 0, 0),
				),
				3 => array(
				    'bba' => 1,
				    'ref' => 1,
				    'vig' => 1,
				    'vol' => 3,
				    'dailySpells' => array(4, 2, 1, 0, 0, 0, 0, 0, 0, 0),
				),
				4 => array(
				    'bba' => 2,
				    'ref' => 1,
				    'vig' => 1,
				    'vol' => 4,
				    'dailySpells' => array(4, 3, 2, 0, 0, 0, 0, 0, 0, 0),
				),
				5 => array(
				    'bba' => 2,
				    'ref' => 1,
				    'vig' => 1,
				    'vol' => 4,
				    'specials' => array(
					   'DONSUPPLEMENTAIRE' => 'don supplémentaire',
				    ),
				    'dailySpells' => array(4, 3, 2, 1, 0, 0, 0, 0, 0, 0),
				),
				6 => array(
				    'bba' => 3,
				    'ref' => 2,
				    'vig' => 2,
				    'vol' => 5,
				    'dailySpells' => array(4, 3, 3, 2, 0, 0, 0, 0, 0, 0),
				),
				7 => array(
				    'bba' => 3,
				    'ref' => 2,
				    'vig' => 2,
				    'vol' => 5,
				    'dailySpells' => array(4, 4, 3, 2, 1, 0, 0, 0, 0, 0),
				),
				8 => array(
				    'bba' => 4,
				    'ref' => 2,
				    'vig' => 2,
				    'vol' => 6,
				    'dailySpells' => array(4, 4, 3, 3, 2, 0, 0, 0, 0, 0),
				),
				9 => array(
				    'bba' => 4,
				    'ref' => 3,
				    'vig' => 3,
				    'vol' => 6,
				    'dailySpells' => array(4, 4, 4, 3, 2, 1, 0, 0, 0, 0),
				),
				10 => array(
				    'bba' => 5,
				    'ref' => 3,
				    'vig' => 3,
				    'vol' => 7,
				    'dailySpells' => array(4, 4, 4, 3, 3, 2, 0, 0, 0, 0),
				),
				11 => array(
				    'bba' => 5,
				    'ref' => 3,
				    'vig' => 3,
				    'vol' => 7,
				    'dailySpells' => array(4, 4, 4, 4, 3, 2, 1, 0, 0, 0),
				),
				12 => array(
				    'bba' => 6,
				    'ref' => 4,
				    'vig' => 4,
				    'vol' => 8,
				    'dailySpells' => array(4, 4, 4, 4, 3, 3, 2, 0, 0, 0),
				),
				13 => array(
				    'bba' => 6,
				    'ref' => 4,
				    'vig' => 4,
				    'vol' => 8,
				    'dailySpells' => array(4, 4, 4, 4, 4, 3, 2, 1, 0, 0),
				),
				14 => array(
				    'bba' => 7,
				    'ref' => 4,
				    'vig' => 4,
				    'vol' => 9,
				    'dailySpells' => array(4, 4, 4, 4, 4, 3, 3, 2, 0, 0),
				),
				15 => array(
				    'bba' => 7,
				    'ref' => 5,
				    'vig' => 5,
				    'vol' => 9,
				    'dailySpells' => array(4, 4, 4, 4, 4, 4, 3, 2, 1, 0),
				),
				16 => array(
				    'bba' => 8,
				    'ref' => 5,
				    'vig' => 5,
				    'vol' => 10,
				    'dailySpells' => array(4, 4, 4, 4, 4, 4, 3, 3, 2, 0),
				),
				17 => array(
				    'bba' => 8,
				    'ref' => 5,
				    'vig' => 5,
				    'vol' => 10,
				    'dailySpells' => array(4, 4, 4, 4, 4, 4, 4, 3, 2, 1),
				),
				18 => array(
				    'bba' => 9,
				    'ref' => 6,
				    'vig' => 6,
				    'vol' => 11,
				    'dailySpells' => array(4, 4, 4, 4, 4, 4, 4, 3, 3, 2),
				),
				19 => array(
				    'bba' => 9,
				    'ref' => 6,
				    'vig' => 6,
				    'vol' => 11,
				    'dailySpells' => array(4, 4, 4, 4, 4, 4, 4, 4, 3, 3),
				),
				20 => array(
				    'bba' => 10,
				    'ref' => 6,
				    'vig' => 6,
				    'vol' => 12,
				    'dailySpells' => array(4, 4, 4, 4, 4, 4, 4, 4, 4, 4),
				),
			 )
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

		  foreach ($data['levels'] as $id_level => $dataLevel) {
			 $level = new CharacterClassLevel();
			 $level->setLevel($id_level);
			 $level->setBba($dataLevel['bba']);
			 $level->setRef($dataLevel['ref']);
			 $level->setVig($dataLevel['vig']);
			 $level->setVol($dataLevel['vol']);
                         foreach ($dataLevel['specials'] as $dataSpecial) {
                             $special = new CharacterClassSpecial();
                             $special->setName($dataSpecial['name']);
                             $special->setName($dataSpecial['nameId']);
                             $special->setName($dataSpecial['name']);
                             $special->setName($dataSpecial['name']);
                             $level->addSpecial($special);
                         }
			 $level->setDailySpells($dataLevel['dailySpells']);
			 $class->addLevel($level);
		  }

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
