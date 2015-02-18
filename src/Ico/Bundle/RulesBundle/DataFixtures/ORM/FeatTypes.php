<?php

namespace Ico\Bundle\TrainingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ico\Bundle\RulesBundle\Entity\FeatType;

class FeatTypes implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
	   $wiki = 'http://www.pathfinder-fr.org/Wiki/Pathfinder-RPG.Dons.ashx';
	   $feat_types = array(
		  array(
			 'name_id' => 'general',
			 'name' => 'Général',
			 'description' => '',
			 'detail' => '',
			 'wiki' => $wiki,
			 'icon' => ''
		  ),
		  array(
			 'name_id' => 'combat',
			 'name' => 'Combat',
			 'description' => "Un don de combat peut être choisi comme don en bonus de guerrier. Cette appellation ne limite pas l'accès aux dons aux autres classes, si tant est qu'elles remplissent les conditions nécessaires.",
			 'detail' => "Un don de combat peut être choisi comme don en bonus de guerrier. Cette appellation ne limite pas l'accès aux dons aux autres classes, si tant est qu'elles remplissent les conditions nécessaires.",
			 'wiki' => $wiki,
			 'icon' => ''
		  ),
		  array(
			 'name_id' => 'grit',
			 'name' => 'Audace',
			 'description' => "Un don d'audace interagit avec l'audace du pistolier, avec celle d'un pouvoir de classe ou avec celle qui découle du don Pistolier amateur. Il élargit généralement l'éventail d'exploits. Parfois, ces dons augmentent le nombre de points d'audace du personnage ou modifient sa manière de les récupérer. Un pistolier peut choisir un don d'audace comme don supplémentaire.",
			 'detail' => "Un don d'audace interagit avec l'audace du pistolier, avec celle d'un pouvoir de classe ou avec celle qui découle du don Pistolier amateur. Il élargit généralement l'éventail d'exploits. Parfois, ces dons augmentent le nombre de points d'audace du personnage ou modifient sa manière de les récupérer. Un pistolier peut choisir un don d'audace comme don supplémentaire.",
			 'wiki' => $wiki,
			 'icon' => ''
		  ),
		  array(
			 'name_id' => 'monster',
			 'name' => 'Monstre',
			 'description' => 'Un don réservé à des personnages monstrueux.',
			 'detail' => 'Un don réservé à des personnages monstrueux.',
			 'wiki' => $wiki,
			 'icon' => ''
		  ),
		  array(
			 'name_id' => 'metamagic',
			 'name' => 'Métamagie',
			 'description' => "À mesure que les connaissances magiques d'un lanceur de sorts augmentent, il peut apprendre à jeter des sorts à l'aide de méthodes légèrement différentes de celles qu'on lui a enseignées. Préparer et lancer les sorts ainsi présente davantage de difficultés que les méthodes classiques, mais les dons de métamagie permettent de repousser ses limites.",
			 'detail' => "À mesure que les connaissances magiques d'un lanceur de sorts augmentent, il peut apprendre à jeter des sorts à l'aide de méthodes légèrement différentes de celles qu'on lui a enseignées. Préparer et lancer les sorts ainsi présente davantage de difficultés que les méthodes classiques, mais les dons de métamagie permettent de repousser ses limites. Voir la liste des dons de métamagie.<br />
<br />
<b>Magiciens et pratiquants de la magie divine.</b> Les magiciens et les pratiquants de la magie divine doivent préparer leurs sorts à l'avance. C'est à ce moment qu'ils décident s'ils souhaitent les préparer en les modifiant grâce à des dons de métamagie (ce qui les oblige à utiliser des emplacements de sorts de niveau supérieur).<br />
<br />
<b>Bardes et ensorceleurs.</b> En revanche, les bardes et les ensorceleurs choisissent leurs sorts quand ils les jettent. Ils décident donc au dernier moment s'ils souhaitent augmenter la puissance de leur sort à l'aide d'un don de métamagie. Pour eux aussi, le sort requiert un emplacement de niveau supérieur. Comme le personnage ne prépare pas le sort à l'avance, il est obligé de rallonger le temps d'incantation afin d'intégrer le don de métamagie au sort qu'il récite. Si le temps d'incantation normal du sort équivaut à une action simple, un barde ou ensorceleur aura besoin d'une action complexe pour le lancer en tant que sort de métamagie (ce qui ne correspond pas à un temps d'incantation d'un round entier). Les sorts modifiés par le don de métamagie Incantation rapide représentent la seule exception à la règle et se lancent de la façon déterminée par ce don.<br />
<br />
Pour les sorts à incantation plus longue, il faut rajouter une action complexe au temps donné.<br />
<br />
<b>Sorts spontanés et dons de métamagie.</b> Les prêtres et les druides lançant spontanément des sorts de soins, de blessure ou de convocation d'alliés naturels peuvent également utiliser la métamagie. Le temps d'incantation augmente aussi dans ce cas. Si le temps d'incantation normal du sort est d'une action simple, sa version métamagique nécessite une action complexe. Pour les sorts à incantation plus longue, il faut rajouter une action complexe au temps indiqué. Les sorts modifiés par le don de métamagie Incantation rapide représentent la seule exception à la règle et se lancent comme une action rapide.<br />
<br />
<b>Effet des dons de métamagie sur un sort.</b> Un sort de métamagie fonctionne selon son niveau d'origine, même s'il est préparé et lancé comme un sort de niveau supérieur. Le jet de sauvegarde ne change pas à moins que la description du don n'indique le contraire.<br />
<br />
Les changements indiqués fonctionnent uniquement sur les sorts jetés directement par le personnage. Il est impossible d'utiliser un don de métamagie sur un sort lancé via un parchemin, une baguette ou un autre objet magique.<br />
<br />
Les dons de métamagie qui dispensent de composantes n'empêchent pas les attaques d'opportunité provoquées par l'incantation d'un sort dans un espace contrôlé par un adversaire. Cependant, un sort à incantation rapide (modifié par le don Incantation rapide) ne provoque pas d'attaque d'opportunité.<br />
<br />
Les dons de métamagie ne peuvent pas être utilisés pour tous les sorts. Consultez la description de chaque don pour connaître les sorts qu'il ne peut pas affecter.<br />
<br />
<b>Dons de métamagie multiples sur un même sort.</b> On peut multiplier les dons de métamagie utilisés sur un sort, mais l'augmentation de niveau est cumulative. Il est impossible d'appliquer deux fois le même don de métamagie à un sort donné.<br />
<br />
<b>Objets magiques et dons de métamagie.</b> Avec le don de création d'objets idoine, on peut stocker un sort de métamagie dans une potion, un parchemin ou une baguette. La limite de niveau concernant les baguettes et les potions s'applique au niveau du sort après modification (après l'application du don de métamagie). Il n'est pas nécessaire d'avoir le don de métamagie correspondant pour activer un objet de ce type.<br />
<br />
<b>Contresorts et dons de métamagie.</b> Qu'un sort ait été modifié ou non par métamagie, il est toujours vulnérable aux contresorts, et reste lui-même un contresort efficace.",
			 'wiki' => $wiki,
			 'icon' => ''
		  ),
		  array(
			 'name_id' => 'style',
			 'name' => 'École',
			 'description' => "Par une action rapide, le personnage peut adopter la posture de référence de l'école liée au don. Il ne peut pas utiliser de don d'école avant le début du combat mais il conserve la posture choisie jusqu'à ce qu'il dépense une action rapide pour changer d'école. Si une école particulière figure dans les conditions requises d'un don, le personnage doit obligatoirement se trouver dans la posture de cette école pour l'utiliser.",
			 'detail' => "À mesure que les connaissances magiques d'un lanceur de sorts augmentent, il peut apprendre à jeter des sorts à l'aide de méthodes légèrement différentes de celles qu'on lui a enseignées. Préparer et lancer les sorts ainsi présente davantage de difficultés que les méthodes classiques, mais les dons de métamagie permettent de repousser ses limites.<br />
<br />
<b>Magiciens et pratiquants de la magie divine.</b> Les magiciens et les pratiquants de la magie divine doivent préparer leurs sorts à l'avance. C'est à ce moment qu'ils décident s'ils souhaitent les préparer en les modifiant grâce à des dons de métamagie (ce qui les oblige à utiliser des emplacements de sorts de niveau supérieur).<br />
<br />
<b>Bardes et ensorceleurs.</b> En revanche, les bardes et les ensorceleurs choisissent leurs sorts quand ils les jettent. Ils décident donc au dernier moment s'ils souhaitent augmenter la puissance de leur sort à l'aide d'un don de métamagie. Pour eux aussi, le sort requiert un emplacement de niveau supérieur. Comme le personnage ne prépare pas le sort à l'avance, il est obligé de rallonger le temps d'incantation afin d'intégrer le don de métamagie au sort qu'il récite. Si le temps d'incantation normal du sort équivaut à une action simple, un barde ou ensorceleur aura besoin d'une action complexe pour le lancer en tant que sort de métamagie (ce qui ne correspond pas à un temps d'incantation d'un round entier). Les sorts modifiés par le don de métamagie Incantation rapide représentent la seule exception à la règle et se lancent de la façon déterminée par ce don.<br />
<br />
Pour les sorts à incantation plus longue, il faut rajouter une action complexe au temps donné.<br />
<br />
<b>Sorts spontanés et dons de métamagie.</b> Les prêtres et les druides lançant spontanément des sorts de soins, de blessure ou de convocation d'alliés naturels peuvent également utiliser la métamagie. Le temps d'incantation augmente aussi dans ce cas. Si le temps d'incantation normal du sort est d'une action simple, sa version métamagique nécessite une action complexe. Pour les sorts à incantation plus longue, il faut rajouter une action complexe au temps indiqué. Les sorts modifiés par le don de métamagie Incantation rapide représentent la seule exception à la règle et se lancent comme une action rapide.<br />
<br />
<b>Effet des dons de métamagie sur un sort.</b> Un sort de métamagie fonctionne selon son niveau d'origine, même s'il est préparé et lancé comme un sort de niveau supérieur. Le jet de sauvegarde ne change pas à moins que la description du don n'indique le contraire.<br />
<br />
Les changements indiqués fonctionnent uniquement sur les sorts jetés directement par le personnage. Il est impossible d'utiliser un don de métamagie sur un sort lancé via un parchemin, une baguette ou un autre objet magique.<br />
<br />
Les dons de métamagie qui dispensent de composantes n'empêchent pas les attaques d'opportunité provoquées par l'incantation d'un sort dans un espace contrôlé par un adversaire. Cependant, un sort à incantation rapide (modifié par le don Incantation rapide) ne provoque pas d'attaque d'opportunité.<br />
<br />
Les dons de métamagie ne peuvent pas être utilisés pour tous les sorts. Consultez la description de chaque don pour connaître les sorts qu'il ne peut pas affecter.<br />
<br />
<b>Dons de métamagie multiples sur un même sort.</b> On peut multiplier les dons de métamagie utilisés sur un sort, mais l'augmentation de niveau est cumulative. Il est impossible d'appliquer deux fois le même don de métamagie à un sort donné.<br />
<br />
<b>Objets magiques et dons de métamagie.</b> Avec le don de création d'objets idoine, on peut stocker un sort de métamagie dans une potion, un parchemin ou une baguette. La limite de niveau concernant les baguettes et les potions s'applique au niveau du sort après modification (après l'application du don de métamagie). Il n'est pas nécessaire d'avoir le don de métamagie correspondant pour activer un objet de ce type.<br />
<br />
<b>Contresorts et dons de métamagie.</b> Qu'un sort ait été modifié ou non par métamagie, il est toujours vulnérable aux contresorts, et reste lui-même un contresort efficace.",
			 'wiki' => $wiki,
			 'icon' => ''
		  ),
		  array(
			 'name_id' => 'team',
			 'name' => 'Équipe',
			 'description' => "Les dons d'équipe offrent des bonus importants, mais ils ne fonctionnent que sous certaines conditions. Dans la plupart des cas, ils nécessitent la présence d'un allié possédant également le don en question et sa présence à un endroit précis du champ de bataille. Les dons d'équipe ne donnent aucun bonus si les conditions précisées ne sont pas remplies. Notez que les alliés qui sont paralysés, étourdis, inconscients ou incapables d'agir pour une raison ou une autre ne permettent pas de remplir les conditions de ces dons.",
			 'detail' => "Les dons d'équipe offrent des bonus importants, mais ils ne fonctionnent que sous certaines conditions. Dans la plupart des cas, ils nécessitent la présence d'un allié possédant également le don en question et sa présence à un endroit précis du champ de bataille. Les dons d'équipe ne donnent aucun bonus si les conditions précisées ne sont pas remplies. Notez que les alliés qui sont paralysés, étourdis, inconscients ou incapables d'agir pour une raison ou une autre ne permettent pas de remplir les conditions de ces dons.",
			 'wiki' => $wiki,
			 'icon' => ''
		  ),
		  array(
			 'name_id' => 'performance',
			 'name' => 'Spectacle',
			 'description' => "Ces dons servent lors des tests de combat de spectacle et donnent souvent droit à une action spéciale qui se produit lors du test. À moins que le personnage ne dispose du don Démonstration de maître, il ne peut utiliser qu'un don de spectacle par test.",
			 'detail' => "Ces dons servent lors des tests de combat de spectacle et donnent souvent droit à une action spéciale qui se produit lors du test. À moins que le personnage ne dispose du don Démonstration de maître, il ne peut utiliser qu'un don de spectacle par test.",
			 'wiki' => $wiki,
			 'icon' => ''
		  ),
		  array(
			 'name_id' => 'critical',
			 'name' => 'Critique',
			 'description' => "Les dons de critique modifient les effets des coups critiques en infligeant une condition négative supplémentaire aux victimes. Les personnages qui ne disposent pas du don Maîtrise du critique appliquent un effet de don de critique au maximum quand ils infligent un coup critique. Les personnages qui disposent de plusieurs dons de critique choisissent celui qu'ils souhaitent appliquer une fois le critique confirmé.",
			 'detail' => "Les dons de critique modifient les effets des coups critiques en infligeant une condition négative supplémentaire aux victimes. Les personnages qui ne disposent pas du don Maîtrise du critique appliquent un effet de don de critique au maximum quand ils infligent un coup critique. Les personnages qui disposent de plusieurs dons de critique choisissent celui qu'ils souhaitent appliquer une fois le critique confirmé.",
			 'wiki' => $wiki,
			 'icon' => ''
		  ),
		  array(
			 'name_id' => 'itemCreation',
			 'name' => 'Création d\'objets',
			 'description' => "Les dons de création d'objets permettent au personnage de créer des objets d'un type précis. Tous les dons de cette catégorie possèdent des points communs, quel que soit le type d'objet concerné.",
			 'detail' => "Les dons de création d'objets permettent au personnage de créer des objets d'un type précis. Tous les dons de cette catégorie possèdent des points communs, quel que soit le type d'objet concerné. Voir la liste des dons de création d'objets.<br />
<br />
<b>Coût des matières premières.</b> Le coût de création d'un objet magique équivaut à la moitié du prix de base de l'objet.<br />
<br />
Pour pouvoir utiliser un don de création d'objet, il faut avoir accès à un laboratoire ou à un atelier de magie, aux ustensiles appropriés, etc. Le personnage possède généralement tout ce dont il a besoin, sauf circonstances exceptionnelles.<br />
<br />
<b>Temps nécessaire.</b> Le temps de création d'un objet magique dépend du don concerné et du coût de l'objet.<br />
<br />
<b>Coût de l'objet.</b> Création de baguettes magiques, Création de bâtons magiques, Écriture de parchemins et Préparation de potions permettent de fabriquer des objets qui reproduisent directement les effets d'un sort et dont la puissance dépend de leur niveau de lanceur de sorts. Donc, les sorts lancés par ces objets ont la même puissance que s'ils étaient directement lancés par un lanceur de sorts de ce niveau. Le prix de ces objets (et donc leur coût en matières premières) dépend lui aussi de leur niveau de lanceur de sorts. Le créateur doit avoir un niveau de lanceur de sorts suffisamment haut pour pouvoir jeter le sort correspondant sur son objet. Pour trouver le prix de base de l'objet, il suffit de multiplier le niveau du sort par le niveau de lanceur de sorts de l'objet et de multiplier le résultat obtenu par une constante, comme suit :<br />
<br />
<ul>
<li><b>Parchemin :</b> prix de base = niveau de sort x NLS x 25 po.</li>
<li><b>Potion :</b> prix de base = niveau de sort x NLS x 50 po.</li>
<li><b>Baguette :</b> prix de base = niveau de sort x NLS x 750 po.</li>
<li><b>Bâtons :</b> Le prix des bâtons se calcule à l'aide d'une formule plus complexe (voir ici).</li>
</ul>
<br />
Pour ce calcul, les sorts du niveau 0 comptent comme des sorts de niveau 1/2.<br />
<br />
<b>Coûts supplémentaires.</b> Les potions, parchemins et baguettes qui stockent un sort nécessitant une composante matérielle coûteuse exigent une dépense supplémentaire, hors du prix de base. Pour une potion ou un parchemin, le personnage doit payer le prix indiqué dans la description du sort en composantes matérielles. Pour une baguette, il doit acquitter cinquante fois le prix exigé par le sort. Certains objets s'accompagnent également d'un coût supplémentaire, indiqué dans leur description.<br />
<br />
<b>Test de compétence.</b> Pour créer un objet magique, il faut réussir un test d'Art de la magie DD 5 + niveau de lanceur de sorts de l'objet. Le personnage peut également utiliser une compétence d'Artisanat ou de Profession adaptée à l'objet qu'il fabrique. Consultez la section sur la Création d'objets magiques pour plus de détails sur les tests d'Artisanat et de Profession qui peuvent remplacer le test d'Art de la magie. Le DD du test peut augmenter si l'artisan est pressé ou s'il ne remplit pas toutes les conditions. En cas d'échec, les composantes matérielles sont perdues, mais si le personnage échoue de cinq ou plus, il produit un objet maudit.",
			 'wiki' => $wiki,
			 'icon' => ''
		  ),
	   );

	   foreach ($feat_types as $data) {
		  $feat_type = new FeatType();
		  $feat_type->setNameId($data['name_id']);
		  $feat_type->setName($data['name']);
		  $feat_type->setDescription($data['description']);
		  $feat_type->setDetail($data['detail']);
		  $feat_type->setWiki($data['wiki']);
		  $manager->persist($feat_type);
	   }
	   $manager->flush();
    }

    public function getOrder() {
	   return 1;
    }

}
