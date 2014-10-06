<?php

namespace Kiwi\Bundle\TrainingBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ico\Bundle\RulesBundle\Entity\SpellSchool;

class SpellSchools implements FixtureInterface, OrderedFixtureInterface {

    public function load(ObjectManager $manager) {
	   
	   $schools = array(
		  array(
			 'nameId' => 'conjuration',
			 'name' => 'Invocation',
			 'description' => "Il existe cinq branches d’invocations, qui permettent de faire apparaître des objets, des créatures ou de l’énergie (convocation), de faire venir des entités originaires d’un autre plan (appel), de soigner (guérison), de déplacer des créatures ou des objets sur de grandes distances (téléportation) ou de créer des objets ou des effets de toutes pièces (création). Les créatures invoquées obéissent généralement à celui qui les a appelés, mais ce n’est pas systématique.",
			 'detail' => "Il existe cinq branches d’invocations, qui permettent de faire apparaître des objets, des créatures ou de l’énergie (convocation), de faire venir des entités originaires d’un autre plan (appel), de soigner (guérison), de déplacer des créatures ou des objets sur de grandes distances (téléportation) ou de créer des objets ou des effets de toutes pièces (création). Les créatures invoquées obéissent généralement à celui qui les a appelés, mais ce n’est pas systématique.<br />
<br />
Une créature ou un objet transporté ou créé par une invocation ne peut pas se matérialiser dans les airs, ni à un endroit déjà occupé par quelqu’un ou quelque chose. Il doit apparaître à un endroit dégagé, sur une surface capable de le soutenir.<br />
<br />
La créature ou l’objet doit également arriver dans les limites de portée imposées par le sort, même s’il peut se déplacer par la suite.<br />
<br />
<b>Appel.</b> Le sort transporte une créature d’un autre plan dans celui du personnage. Il offre à cette créature la capacité (à usage unique) de retourner dans son plan d’origine, bien qu’il puisse limiter les conditions de ce retour. La créature meurt réellement si elle se fait tuer ; elle ne disparaît pas pour se reformer ailleurs contrairement aux monstres créés par les sorts de convocation (voir plus bas). La durée d’un sort d’appel est instantanée, ce qui veut dire que la créature invoquée ne peut pas être dissipée.<br />
<br />
<b>Convocation.</b> Le sort amène instantanément une créature ou un objet à l’endroit choisi par le lanceur de sorts. Quand le sort arrive à son terme ou s’il est dissipé, la créature convoquée retourne aussitôt d’où elle vient. En revanche, un objet convoqué reste généralement sur place, sauf indication contraire dans la description du sort. Une créature convoquée s’en retourne également si elle est tuée ou si elle tombe à 0 point de vie ou moins. Dans ce cas, elle ne meurt pas vraiment. Il lui faut 24 heures pour se reconstituer, période pendant laquelle il est impossible de l’invoquer de nouveau.<br />
<br />
Lorsque le sort s’achève et que la créature repart, tous les sorts qu’elle a pu lancer se terminent aussitôt. Une créature convoquée ne peut pas faire appel à ses propres pouvoirs de convocation si elle en a.<br />
<br />
<b>Création.</b> Le sort manipule la matière de façon à créer un objet ou une créature à l’endroit choisi par le personnage. Si le sort a une durée autre qu’instantanée, c’est la magie qui permet au monstre ou à l’objet de conserver sa forme. Il disparaît donc sans laisser de trace lorsque le sort s’achève ou s’il est dissipé prématurément. À l’inverse, si le sort est instantané, la créature ou l’objet est créé par magie, ce qui lui permet par la suite d’exister indéfiniment, sans plus dépendre de la magie.<br />
<br />
<b>Guérison.</b> Certaines invocations divines permettent de soigner les créatures, voire de les ramener à la vie.<br />
<br />
<b>Téléportation.</b> Un sort de téléportation déplace un ou plusieurs objets ou créatures sur de grandes distances. Le plus puissant de ces sorts permet de franchir les frontières entre les plans. Contrairement aux sorts de convocation, les sorts de téléportation fonctionnent uniquement dans un sens (à moins qu’il n’en soit précisé autrement) et ne sauraient être dissipés. La téléportation est un mode de déplacement instantané qui passe par le plan Astral. Tout ce qui empêche les voyages astraux empêche donc aussi la téléportation."
		  ),
		  array(
			 'nameId' => 'necromancy',
			 'name' => 'Nécromancie',
			 'description' => "Les sorts de nécromancie ont trait à la mort. Nombre d’entre eux sont en rapport direct avec les morts-vivants.",
			 'detail' => "Les sorts de nécromancie ont trait à la mort. Nombre d’entre eux sont en rapport direct avec les morts-vivants."
		  ),
		  array(
			 'nameId' => 'evocation',
			 'name' => 'Évocation',
			 'description' => "Les sorts d’évocation manipulent l’énergie magique ou puisent dans des sources de puissance invisible pour obtenir le résultat désiré. L’évocation se sert de la magie pour créer quelque chose à partir de rien. La plupart de ces sorts sont très spectaculaires sur le plan visuel, et il n’est pas rare qu’ils provoquent d’importants dégâts.",
			 'detail' => "Les sorts d’évocation manipulent l’énergie magique ou puisent dans des sources de puissance invisible pour obtenir le résultat désiré. L’évocation se sert de la magie pour créer quelque chose à partir de rien. La plupart de ces sorts sont très spectaculaires sur le plan visuel, et il n’est pas rare qu’ils provoquent d’importants dégâts."
		  ),
		  array(
			 'nameId' => 'transmutation',
			 'name' => 'Transmutation',
			 'description' => "Les sorts de transmutation modifient les propriétés d’une créature, d’un objet ou d’une condition.",
			 'detail' => "Les sorts de transmutation modifient les propriétés d’une créature, d’un objet ou d’une condition.<br />
<br />
<b>Métamorphose.</b> Un sort de métamorphose transforme le corps du personnage pour lui donner l’apparence d’une autre créature. Le sort le fait passer pour elle et lui offre donc un bonus de +20 aux tests de Déguisement mais il ne lui accorde pas les capacités ni les pouvoirs de cette créature. Chaque sort de métamorphose permet au personnage de prendre la forme d’une créature d’un type donné et lui accorde des bonus aux caractéristiques et à l’armure naturelle. De plus, chaque sort de métamorphose confère des avantages supplémentaires, comme des mouvements, des résistances ou des sens particuliers. Si la forme choisie donne des avantages ou des aptitudes supérieures du même type, le personnage en bénéficie automatiquement. Si la forme choisie donne une aptitude inférieure, le personnage est obligé de s’y conformer. Sa vitesse de déplacement de base change aussi pour s’accorder à sa nouvelle forme. Si cette forme propose une vitesse de nage ou de creusement, le personnage peut respirer sous l’eau ou sous terre. Le DD de ces aptitudes est égal au DD du sort de métamorphose utilisé pour prendre cette forme.<br />
<br />
En plus de ces avantages, vous gagnez toutes les formes d’attaques naturelles de la créature de base et vous êtes automatiquement formé à leur utilisation.<br />
<br />
Si le sort de métamorphose change la taille du personnage, les nouveaux modificateurs de taille s’appliquent et changent donc les modificateurs de classe d’armure, de bonus d’attaque, de BMO et de Discrétion. Les valeurs de caractéristique du personnage ne changent pas à moins que cela soit précisé dans la description du sort.<br />
<br />
À moins qu’il en soit précisé autrement, le personnage ne peut pas utiliser un sort de métamorphose pour se transformer en un individu donné. Le personnage peut contrôler beaucoup de détails mais son apparence sera toujours celle d’un membre générique de l’espèce choisie. Le personnage ne peut pas utiliser un sort de métamorphose pour se transformer en une créature douée d’un archétype ou en une version évoluée d’une créature.<br />
<br />
Quand le personnage utilise un sort de métamorphose pour se transformer en une créature de type animal, draconique, élémentaire, végétal, en créature magique ou en vermine, son équipement se fond dans son corps. Les objets qui donnent des bonus permanents et n’ont pas besoin d’être activés continuent de fonctionner (à l’exception de ceux qui donnent des bonus d’armure ou de bouclier). Le personnage ne peut pas utiliser d’objets à activer tant qu’il est transformé. Il ne peut pas non plus lancer de sort nécessitant des composantes matérielles (à moins qu’il dispose du don Dispense de composantes matérielles ou Incantation animale) et il peut lancer des sorts à composante somatique ou verbale uniquement si la forme choisie lui permet de parler ou de faire les mouvements requis (dans le cas d’un dragon par exemple). D’autres sorts de métamorphose peuvent être soumis à ce type de restriction s’ils transforment le personnage en quelque chose de différent de sa forme de départ (à l’appréciation du MJ). Si la nouvelle forme du personnage n’oblige pas son équipement à se fondre en lui, l’équipement est redimensionné pour s’accorder au personnage.<br />
<br />
Tant que le personnage est sous l’effet d’un sort de métamorphose, il perd tous les pouvoirs surnaturels et extraordinaires liés à sa forme originelle (comme les sens surdéveloppés, l’odorat et la vision dans le noir). Il perd aussi les attaques naturelles et les mouvements spéciaux qu’il possédait à l’origine. Le personnage perd aussi les aptitudes de classe qui dépendaient de sa forme mais il peut en gagner d’autres (comme un ensorceleur qui se fait pousser des griffes). La plupart de ces modifications devraient tomber sous le sens mais c’est au MJ de décider des aptitudes qui dépendent de la forme et se perdent quand le personnage se métamorphose. La nouvelle forme du personnage peut lui permettre de les récupérer si elle appartient à une créature qui dispose aussi des aptitudes perdues par le personnage.<br />
<br />
Le personnage ne peut être affecté que par un sort de métamorphose à la fois. Si on lui lance un nouveau sort de métamorphose (ou s’il active un sort à effet de métamorphose comme une forme animale), c’est au personnage de décider s’il accepte ce changement ou non. De plus, les sorts qui modifient la taille de leur cible n’ont aucun effet sur un personnage métamorphosé.<br />
<br />
Si le personnage lance un sort de métamorphose sur une créature d’une catégorie de taille inférieure à Petite ou supérieure à Moyenne, il doit ajuster ses valeurs de caractéristique en fonction de la table suivante avant d’appliquer les bonus liés au sort de métamorphose.<br />
<br />
<center>".
'<table class="tablo"><tbody><tr class="titre"><td>Taille originale de la créature</td><td>For</td><td>Dex</td><td>Con</td><td>Nouvelle taille</td></tr><tr class="premier"><td>Infime</td><td>+6</td><td>-6</td><td>—</td><td>Petite</td></tr><tr><td>Minuscule</td><td>+6</td><td>-4</td><td>—</td><td>Petite</td></tr><tr class="alt"><td>Très petite</td><td>+4</td><td>-2</td><td>—</td><td>Petite</td></tr><tr><td>Grande</td><td>-4</td><td>+2</td><td>-2</td><td>Moyenne</td></tr><tr class="alt"><td>Très grande</td><td>-8</td><td>+4</td><td>-4</td><td>Moyenne</td></tr><tr><td>Gigantesque</td><td>-12</td><td>+4</td><td>-6</td><td>Moyenne</td></tr><tr class="alt"><td>Colossale</td><td>-16</td><td>+4</td><td>-8</td><td>Moyenne</td></tr></tbody></table>'.
"</center>"
		  ),
		  array(
			 'nameId' => 'illusion',
			 'name' => 'Illusion',
			 'description' => "Les illusions trompent les sens et l’esprit. Elles incitent les gens à voir des choses qui n’existent pas, à ne pas voir ce qui est là, à entendre des bruits fictifs ou encore à se souvenir de choses qui ne se sont jamais produites.",
			 'detail' => "Les illusions trompent les sens et l’esprit. Elles incitent les gens à voir des choses qui n’existent pas, à ne pas voir ce qui est là, à entendre des bruits fictifs ou encore à se souvenir de choses qui ne se sont jamais produites.<br />
<br />
<b>Chimère.</b> Une chimère crée une fausse sensation. Tous ceux qui en sont victimes perçoivent la même chose, et non une version personnelle légèrement différente de la chimère. Une chimère ne peut pas faire passer une chose pour ce qu’elle n’est pas. Si elle inclut des éléments auditifs, elle ne peut pas imiter un langage intelligible, à moins que la description du sort ne le mentionne expressément. Si la chimère peut reproduire des paroles, c’est forcément dans une langue connue du personnage qui a lancé le sort, sinon, les paroles ne seront que charabia. De même, il est impossible de faire une copie visuelle de quelque chose que l’on n’a jamais vu (ou de reproduire une autre sensation qui n’a pas été expérimentée).<br />
<br />
Comme les chimères et les hallucinations sont irréelles, elles ne peuvent pas reproduire des effets véritables à la façon d’autres types d’illusions. Elles ne peuvent causer de dégâts à des objets ou à des créatures, porter quelque chose, fournir une alimentation ou encore une protection contre les éléments. Par conséquent, elles sont très efficaces pour semer la confusion chez l’ennemi ou le retarder, mais pas pour attaquer directement.<br />
<br />
La CA d’une chimère est égale à 10 + son modificateur de taille.<br />
<br />
<b>Fantasme.</b> Un fantasme fait apparaître une image mentale que le jeteur de sorts et la ou les cibles sont généralement les seuls à voir. La perception imprègne directement l’esprit de la cible. C’est une impression mentale personnelle qui se trouve uniquement dans la tête de la victime et non un faux tableau ou quoi que ce soit d’autre de réellement visible. Ceux qui ne sont pas pris pour cible par le fantasme ne la remarquent même pas. Tous les fantasmes sont des sorts mentaux.<br />
<br />
<b>Hallucination.</b> Une hallucination modifie les perceptions sensorielles du sujet pour lui communiquer de fausses informations (visuelles, olfactives, etc.) sur l’objet concerné voire lui faire croire que celui-ci a disparu.<br />
<br />
<b>Mirage.</b> Les mirages sont semblables aux chimères en ce sens qu’ils génèrent des images mensongères, mais ils ont également un effet mental sur ceux qui les voient . Tous les mirages sont des sorts mentaux.<br />
<br />
<b>Ombre.</b> Les ombres font apparaître des choses partiellement réelles à partir d’une énergie extradimensionnelle. Ces illusions peuvent avoir des effets réels. Une créature blessée par un sort d’ombre subit effectivement des dégâts.<br />
<br />
<b>Illusions et jets de sauvegarde (dévoile).</b> En règle générale, les créatures confrontées à une illusion n’ont pas droit à un jet de sauvegarde pour la percer à jour à moins de l’étudier attentivement ou d’interagir avec elle d’une manière ou d’une autre.<br />
<br />
En cas de jet de sauvegarde réussi, l’illusion est révélée pour ce qu’elle est, mais les chimères et les fantasmes continuent d’apparaître sous forme de silhouettes translucides.<br />
<br />
Si le personnage rate son jet de sauvegarde, il ne se rend compte de rien. Quelqu’un qui a la preuve que l’illusion n’est pas réelle n’a pas besoin de faire de jet de sauvegarde. Si l’une des personnes présentes prend conscience de l’illusion et en informe ses compagnons, ces derniers peuvent effectuer un jet de sauvegarde avec un bonus de +4."
		  ),
		  array(
			 'nameId' => 'abjuration',
			 'name' => 'Abjuration',
			 'description' => "Les abjurations sont des sorts de protection. Elles génèrent des barrières physiques ou magiques, contrent certains pouvoirs (physiques ou magiques), nuisent aux intrus ou bannissent leur cible dans un autre plan d’existence.",
			 'detail' => "Les abjurations sont des sorts de protection. Elles génèrent des barrières physiques ou magiques, contrent certains pouvoirs (physiques ou magiques), nuisent aux intrus ou bannissent leur cible dans un autre plan d’existence.<br />
<br />
Lorsque plusieurs abjurations sont actives à moins de 3 m (2 cases) l’une de l’autre pendant plus de 24 heures, l’interaction de leurs champs magiques provoque quelques fluctuations énergétiques à peine visibles. Le DD lié aux tests de Perception permettant de repérer ces sorts diminue alors de 4.<br />
<br />
Lorsqu’une abjuration crée une barrière qui empêche certaines créatures d’approcher, elle ne les repousse pas pour autant. Si le personnage tente de pousser la barrière contre ces créatures il sent qu’une pression s’exerce contre elle. S’il continue de forcer sur la barrière, le sort se dissipe."
		  ),
		  array(
			 'nameId' => 'enchantment',
			 'name' => 'Enchantement',
			 'description' => "Les enchantements affectent l’esprit des créatures, ce qui permet de les contrôler ou d’influer sur leur comportement.",
			 'detail' => "Les enchantements affectent l’esprit des créatures, ce qui permet de les contrôler ou d’influer sur leur comportement.<br />
<br />
Les enchantements sont des sorts mentaux. Deux branches permettent d’influer sur la créature victime.<br />
<br />
<b>Charme.</b> Le sort modifie la manière dont le sujet perçoit le lanceur de sorts, ce qui l’incite le plus souvent à considérer ce dernier comme un ami.<br />
<br />
<b>Coercition.</b> Le sort oblige la cible à agir d’une façon bien précise ou modifie sa façon de penser. Certaines coercitions déterminent les actions du sujet ou génèrent un effet sur le sujet tandis que d’autres permettent au personnage de donner ses instructions à la cible au moment où il lance le sort et d’autres encore permettent de contrôler la cible en permanence."
		  ),
		  array(
			 'nameId' => 'divination',
			 'name' => 'Divination',
			 'description' => "Les sorts de divination permettent de retrouver des secrets oubliés depuis longtemps, de connaître l’avenir, de découvrir ce qui est caché et de percer les sorts trompeurs à jour.",
			 'detail' => "La plupart des sorts de divination ont une zone d’effet en forme de cône qui se déplace avec le personnage. Le cône définit la zone que le sort peut sonder en 1 round. Si le personnage étudie un même endroit pendant plusieurs rounds, il peut généralement obtenir des indications supplémentaires (voir la description de chaque sort).<br />
<br />
<b>Scrutation.</b> Un sort de scrutation crée un capteur magique invisible qui fournit des informations au personnage. À moins qu'il n’en soit précisé autrement, ce capteur a la même puissance sensorielle que le personnage. Ce degré de perception tient compte des sorts et effets qui le prennent pour cible, mais pas de ceux qui émanent de lui. Cependant, le capteur est un organe sensoriel indépendant qui fonctionne même si le personnage est aveuglé, assourdi ou handicapé au niveau des autres sens.<br />
<br />
Toute créature remarquera le capteur si elle réussit un test de Perception (DD 20 + niveau du sort). Enfin, le capteur peut être dissipé, comme s’il s’agissait d’un sort actif.<br />
<br />
Les feuilles de plomb et autres protections magiques bloquent les sorts de scrutation mais le lanceur de sort sait que son sort est bloqué."
		  ),
		  array(
			 'nameId' => 'universal',
			 'name' => 'Universel',
			 'description' => "",
			 'detail' => ""
		  )
	   );

	   foreach ($schools as $data) {
		  $school = new SpellSchool();
		  $school->setNameId($data['nameId']);
		  $school->setName($data['name']);
		  $school->setDescription($data['description']);
		  $school->setDetail($data['detail']);
		  $manager->persist($school);
	   }
	   $manager->flush();
    }

    public function getOrder() {
	   return 4;
    }

}
