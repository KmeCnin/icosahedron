<?php

namespace Kiwi\Bundle\TrainingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ico\Bundle\RulesBundle\Entity\SpellTargetType;

class SpellTargetTypes implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
	   
	   $types = array(
		  array(
			 'name' => 'Cible',
			 'description' => "Ces sorts fonctionnent uniquement sur une ou plusieurs cibles bien définies. Le personnage les lance sur des créatures ou des objets, comme il est indiqué dans leur description. Le personnage doit voir ou toucher la cible, après quoi il lui faut expressément la choisir. Il n'a pas besoin de choisir sa cible avant la fin de l'incantation.",
			 'detail' => "Certains sorts fonctionnent uniquement sur une ou plusieurs cibles bien définies. Le personnage les lance sur des créatures ou des objets, comme il est indiqué dans leur description. Le personnage doit voir ou toucher la cible, après quoi il lui faut expressément la choisir. Il n'a pas besoin de choisir sa cible avant la fin de l'incantation.<br />
<br />
Si le sort affecte directement celui qui le lance (« Cible : le jeteur de sorts »), il ne s'accompagne ni de jet de sauvegarde, ni de résistance à la magie, ce qui explique que ces deux facteurs n'apparaissent pas dans la description de ces sorts.<br />
<br />
Certains sorts affectent des sujets consentants uniquement. Rentrer dans cette catégorie est une action pouvant être réalisée à n'importe quel instant (même en étant pris au dépourvu ou à un moment qui ne correspond pas à son tour.). Les créatures inconscientes sont automatiquement consentantes, ce qui n'est pas le cas d'un personnage conscient mais immobile ou sans défense (enchaîné, recroquevillé sur lui-même, en train de lutter , paralysé, immobilisé dans le cadre d'une lutte ou stoppé).<br />
<br />
Certains sorts permettent de rediriger l'effet vers de nouvelles cibles ou zones d'effet une fois l'incantation terminée. Il s'agit d'une action de mouvement qui ne provoque pas d'attaque d'opportunité."
		  ),
		  array(
			 'name' => 'Effet',
			 'description' => "Ces sorts créent ou font apparaître des choses plutôt que d'affecter des éléments déjà présents.",
			 'detail' => "Certains sorts créent ou font apparaître des choses plutôt que d'affecter des éléments déjà présents.<br />
<br />
Le personnage doit choisir l'endroit où les objets ou créatures sont sensés apparaître, soit en regardant cet endroit, soit en l'indiquant avec précision. La portée détermine la distance maximale à laquelle le sort prend effet mais, s'il provoque un effet mobile, cet effet pourra ensuite se déplacer sans tenir compte des limites de portée du sort.<br />
<br />
<b>Étendue.</b> Certains sorts, notamment les nuages et les brumes, s'étendent à partir d'un point d'origine, qui doit se situer à une intersection sur la grille de jeu. Ils peuvent alors franchir les angles et atteindre des endroits que le personnage est incapable de voir. Lorsqu'on calcule les distances pour un sort à effet d'étendue, contournez les murs, ne les traversez pas. De la même manière que pour un déplacement, on ne peut avancer en diagonale au niveau d'un angle. Le personnage choisit normalement le point d'origine du sort, mais rien ne l'oblige à voir l'ensemble de la zone d'effet (voir ci-dessous).<br />
<br />
<b>Rayon.</b> Certains sorts se traduisent par un rayon d'énergie. Le personnage choisit sa cible comme s'il utilisait une arme à distance, mais il fait généralement une attaque de contact à distance plutôt qu'une attaque à distance normale. Comme avec une arme à distance, le personnage peut tirer dans le noir ou sur un adversaire invisible dans l'espoir de toucher quelque chose. Il n'est pas obligé de voir la créature qu'il souhaite atteindre, contrairement aux sorts à cible. Par contre, un obstacle ou un individu interposé entre le personnage et sa cible peut bloquer son champ de vision ou offrir un abri à sa cible.<br />
<br />
Si le rayon s'accompagne d'une durée, il s'agit du temps pendant lequel l'effet se produit, pas de celle durant laquelle le rayon reste actif.<br />
<br />
S'il inflige des dégâts, le rayon peut asséner un coup critique, comme n'importe quelle arme. Un tel sort a une chance de réaliser un coup critique sur un 20 naturel et d'infliger des dégâts doublés si le critique est confirmé."
		  ),
		  array(
			 'name' => 'Zone d\'effet',
			 'description' => "Ces sorts affectent une zone entière.",
			 'detail' => "Certains sorts affectent une zone entière. Parfois, la description du sort définit précisément la zone d'effet mais, la plupart du temps, celle-ci entre dans l'une des catégories décrites plus loin.<br />
<br />
Quelle que soit la forme que prend la zone d'effet, le personnage choisit son point d'origine mais il est ensuite incapable de décider qui sera affecté ou non. Le point d'origine d'un sort se trouve toujours à une intersection sur la grille. Pour savoir si une créature se trouve ou non dans la zone concernée, comptez la distance en cases à partir du point d'origine, comme vous le faites pour un déplacement ou pour calculer la portée d'une attaque à distance. La seule différence, c'est qu'au lieu de compter du centre d'une case jusqu'au centre de la suivante, vous comptez d'intersection en intersection.<br />
<br />
Vous pouvez compter les cases en diagonales mais n'oubliez pas qu'une diagonale sur deux compte pour 2 cases. Si le bord le plus éloigné d'une case se trouve dans la zone d'effet, tout ce qui se trouve dans cette case est affecté par le sort. Par contre, si l'effet ne touche que le bord le plus proche de la case, le sort n'affecte rien de ce qui se trouve dedans.<br />
<br />
<b>Rayonnement, émanation ou étendue.</b> La plupart des sorts qui affectent une zone fonctionnent comme un rayonnement, une émanation ou une étendue. Dans chacun des cas, vous déterminez le point d'origine du sort et mesurez son effet en vous en éloignant.<br />
<br />
Un <i>rayonnement</i> affecte tout ce qui se trouve dans la zone d'effet, y compris les créatures que le lanceur de sorts ne peut voir. En revanche, il n'affecte pas les créatures qui bénéficient d'un abri total vis-à-vis du point d'origine (en d'autres termes, il ne franchit pas les angles). Par défaut, un rayonnement prend la forme d'une sphère, mais certains ressemblent à un cône. Tout sort de ce type s'accompagne d'un rayon qui délimite la zone d'effet du sort.<br />
<br />
Une <i>émanation</i> fonctionne comme un rayonnement, si ce n'est que son effet continue d'irradier depuis son point d'origine pendant toute la durée du sort. La plupart des émanations prennent la forme d'une sphère ou d'un cône.<br />
<br />
Une <i>étendue</i> se propage comme un rayonnement mais elle peut franchir les angles. Le personnage sélectionne uniquement le point d'origine, et le sort s'étend dans toutes les directions sur une distance donnée. Pour estimer la distance parcourue, le personnage doit tenir compte des éventuels tournants pris par le sort.<br />
<br />
<b>Cône, cylindre, ligne ou sphère.</b> La plupart des sorts qui affectent une zone ont une forme précise.<br />
<br />
Un <i>cône</i> prend la forme d'un quart de cercle qui irradie depuis le lanceur de sorts. Il part de n'importe quel coin de la case du personnage puis s'élargit dans la direction indiquée par celui-ci. La plupart des cônes sont des étendues ou des émanations (voir ci-dessus) et ne franchissent donc pas les angles.<br />
<br />
Quand le personnage lance un sort à effet <i>cylindrique</i>, il décide de son point d'origine. Ce point est le centre d'un cercle horizontal et le sort descend de ce cercle pour remplir un cylindre. Un sort de forme cylindrique ignore tous les obstacles de la zone.<br />
<br />
Une <i>ligne</i> émane du personnage et s'étend dans la direction qu'il indique. Elle part de l'un des coins de sa case et s'étire jusqu'à atteindre la limite de portée du sort ou jusqu'à ce qu'un obstacle la bloque. Une ligne affecte toutes les créatures présentent dans les cases traversées.<br />
<br />
Une <i>sphère</i> se développe depuis son point d'origine jusqu'à remplir une zone sphérique. Les sphères sont des rayonnements, des émanations ou des étendues.<br />
<br />
<b>Créatures.</b> Certains sorts affectent directement des créatures (comme ceux dits « à cible ») mais, dans ce cas, ils affectent toutes les créatures comprises dans la zone d'effet et non pas seulement les créatures choisies par le lanceur de sort. La zone d'effet en question peut prendre la forme d'un rayonnement sphérique, d'un rayonnement conique, ou encore une autre forme.<br />
<br />
Nombre de sorts affectent seulement les « créatures vivantes », ce qui exclut les morts-vivants et les créatures artificielles. Les créatures qui se trouvent dans la zone d'effet du sort mais ne sont pas de type approprié ne comptent pas au nombre des créatures affectées.<br />
<br />
<b>Objets.</b> Ces sorts affectent les objets de la zone choisie (comme pour les sort qui affectent les « Créatures » mais ils ciblent des objets).<br />
<br />
<b>Autre.</b> Un sort peut aussi avoir une zone d'effet particulière, comme indiqué dans sa description.<br />
<br />
<b>(F) Façonnable.</b> Lorsque les indications données dans « Zone d'effet » se terminent par (F), le personnage peut façonner son sort. Dans ce cas, aucune des dimensions du sort ne peut être inférieure à trois mètres. Nombre de zones d'effet sont exprimées en cubes afin de faciliter leur réarrangement en formes irrégulières. Il est bien souvent indispensable d'utiliser des volumes pour définir la zone d'effet d'un sort lancé sous l'eau ou dans les airs."
		  ),
		  array(
			 'name' => 'Ligne d\'effet',
			 'description' => "Une ligne d'effet est une ligne droite ininterrompue qui détermine tout ce que le sort peut affecter. Elle s'interrompt dès qu'elle rencontre un obstacle solide. Elle ressemble à la ligne de mire des armes à distance mais elle n'est pas bloquée par le brouillard, l'obscurité ou tout autre facteur gênant la vision.",
			 'detail' => "Une ligne d'effet est une ligne droite ininterrompue qui détermine tout ce que le sort peut affecter. Elle s'interrompt dès qu'elle rencontre un obstacle solide. Elle ressemble à la ligne de mire des armes à distance mais elle n'est pas bloquée par le brouillard, l'obscurité ou tout autre facteur gênant la vision.<br />
<br />
Pour lancer un sort, le personnage doit disposer d'une ligne d'effet dégagée jusqu'à sa cible ou jusqu'à l'endroit où il souhaite placer le point d'origine de son sort.<br />
<br />
Les rayonnements, les cônes, les cylindres et autres émanations affectent uniquement la zone, les créatures ou les objets que l'on peut relier par une ligne d'effet ininterrompue avec le point d'origine du sort (le centre du rayonnement, le point de départ du cône, le cercle du cylindre ou le point d'origine de l'émanation).<br />
<br />
Une barrière solide dans laquelle il y a un trou d'au moins un mètre carré ne constitue plus un obstacle pour la ligne d'effet d'un sort. Une telle ouverture signifie que la zone de mur d'un mètre cinquante contenant le trou n'est plus considéré comme une barrière pour ce qui est de la ligne d'effet du sort."
		  ),
	   );

	   foreach ($types as $data) {
		  $type = new SpellTargetType();
		  $type->setName($data['name']);
		  $type->setDescription($data['description']);
		  $type->setDetail($data['detail']);
		  $manager->persist($type);
	   }
	   $manager->flush();
    }

    public function getOrder() {
	   return 9;
    }

}
