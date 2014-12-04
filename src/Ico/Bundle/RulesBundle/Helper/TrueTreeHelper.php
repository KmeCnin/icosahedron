<?php

namespace Ico\Bundle\RulesBundle\Helper;

/**
 * Helper permettant de représenter une structure arborescente dont chaque élément a plusieurs parents et plusieurs enfants
 * 
 * L'entité doit posséder une méthode getParents() 
 * retournant la liste de ses entités parentes 
 * et une méthode getChildren() 
 * retournant le liste de ses entités enfants
 * 
 */
class TrueTreeHelper {
    
    /**
     *
     * @var protected array $tree Array contenant les nouveaux d'arborescence de l'arbre
     * numérotés en négatifs pour les parents
     * numérotés en positif pour les enfants
     * le niveau 0 correspond au niveau de l'entité de base
     * 
     * Chaque niveau contient une liste d'entités
     */
    protected $tree;
    
    /**
     *
     * @var protected array $treeDisplayed
     * 
     * Même structure que $tree mais chaque élément est composé d'un id de l'entité 
     * ainsi que d'un booléen indiquant si l'entité a déjà été affichée dans l'arbre
     */
    protected $treeDisplayed;
    
    /**
     *
     * @var protected array $usedEntities Array contenant la liste des id des entités utilisées 
     * lors de la construction de l'arborescence 
     * afin d'éviter les répétitions
     */
    protected $usedEntities;

    /**
     * 
     * @param object $entity Doit être une entité valide (comprenant une méthode getParents() et getChildren())
     * 
     * @throws Exception
     */
    function __construct($entity) {
	   
	   // On vérifie que l'entitée passée respecte bien l'architecture multi-arborescente
	   if (!method_exists($entity, 'getParents') || !method_exists($entity, 'getChildren')) {
		  throw Exception('L\'entité doit posséder une méthode getParents() et une méthode getChildren()');
	   }
	   
	   // On récupère le dessus de l'arbre
	   $this->usedEntities = array();
	   $this->setAscendingTree($entity, 0);
	   // On récupère le dessous de l'arbre
	   $this->usedEntities = array();
	   $this->setDescendingTree($entity, 0);
	   // On réorganise l'array pour avoir une représentation arborescente
	   ksort($this->tree);
	   $this->tree[0] = array($this->tree[0][0]);
	   
    }

    /**
     * Fonction récursive récupérer pour chaque itération les parents de l'entité 
     * et s'appelant elle-même pour chaque parent ainsi récupéré
     * 
     * @param object $entity
     * @param integer $level Niveau de profondeur commençant à -1 pour les parents directes et décrémenté à chaque itération
     */
    protected function setAscendingTree($entity, $level) {
	   
	   $this->tree[$level][] = $entity;
	   $this->treeDisplayed[$level][$entity->getId()] = false;
	   
	   if (in_array($entity->getId(), $this->usedEntities)) {
		  // L'entité a déjà été utilisé dans l'arborescence
		  $this->removeNearestFromAscendingTree($entity->getId());
	   } else {
		  // On ajoute l'entité à la liste des entités déjà utilisées
		  $this->usedEntities[] = $entity->getId();
	   }
	   $level--;
	   
	   if ($entity->getParents() !== null) {
		  foreach ($entity->getParents() as $parent) {
			 $this->setAscendingTree($parent, $level);
		  }
	   }
	   
    }

    /**
     * Fonction récursive récupérer pour chaque itération les enfants de l'entité 
     * et s'appelant elle-même pour chaque enfant ainsi récupéré
     * 
     * @param object $entity
     * @param integer $level Niveau de profondeur commençant à 1 pour les enfants directes et incrémenté à chaque itération
     */
    protected function setDescendingTree($entity, $level) {
	   
	   $this->tree[$level][] = $entity;
	   
	   if (in_array($entity->getId(), $this->usedEntities)) {
		  // L'entité a déjà été utilisé dans l'arborescence
		  $this->removeNearestFromDescendingTree($entity->getId());
	   } else {
		  // On ajoute l'entité à la liste des entités déjà utilisées
		  $this->usedEntities[] = $entity->getId();
	   }
	   $level++;
	   
	   if ($entity->getChildren() !== null) {
		  foreach ($entity->getChildren() as $child) {
			 $this->setDescendingTree($child, $level);
		  }
	   }
	   
    }
    
    /**
     * Supprime l'entité indiquée en cherchant l'occurence la plus proche du niveau 0
     * afin d'aléger l'arborescence de manière optimisée
     * 
     * @param integer $entity_id Id de l'entité à supprimer
     */
    protected function removeNearestFromAscendingTree($entity_id) {
	   
	   $lowest_level = (count($this->getAscendingTree())-1) * -1;
	   // Récupération du niveau de l'occurence la plus basse
	   foreach($this->getAscendingTree() as $level => $entities) {
		  foreach($entities as $entity) {
			 if ($entity->getId() == $entity_id && $level > $lowest_level) {
				$lowest_level = $level;
			 }
		  }
	   }
	   // Suppression de cette occurence
	   foreach ($this->tree[$lowest_level] as $index => $entity) {
		  if ($entity->getId() == $entity_id) {
			 unset($this->tree[$lowest_level][$index]);
			 break;
		  }
	   }
	   
    }
    
    /**
     * Supprime l'entité indiquée en cherchant l'occurence la plus proche du niveau 0
     * afin d'aléger l'arborescence de manière optimisée
     * 
     * @param integer $entity_id Id de l'entité à supprimer
     */
    protected function removeNearestFromDescendingTree($entity_id) {
	   
	   $lowest_level = count($this->getDescendingTree())-1;
	   // Récupération du niveau de l'occurence la plus basse
	   foreach($this->getDescendingTree() as $level => $entities) {
		  foreach($entities as $entity) {
			 if ($entity->getId() == $entity_id && $level < $lowest_level) {
				$lowest_level = $level;
			 }
		  }
	   }
	   // Suppression de cette occurence
	   foreach ($this->tree[$lowest_level] as $index => $entity) {
		  if ($entity->getId() == $entity_id) {
			 unset($this->tree[$lowest_level][$index]);
			 break;
		  }
	   }
	   
    }
    
    /**
     * Affiche les données de $this->tree de manière intelligible pour pouvoir débugger
     */
    public function displayTree() {
	   echo '<ul>';
	   foreach($this->tree as $level => $entities) {
		  echo '<li>'.$level;
		  echo '<ul>';
		  foreach($entities as $entity) {
			 echo '<li>'.$entity->getName().'</li>';
		  }
		  echo '</ul>';
		  echo '</li>';
	   }
	   echo '</ul>';
    }
    
    /**
     * Getter
     * 
     * @return array $this->tree
     */
    public function getTree() {
	   return $this->tree;
    }
    
    /**
     * Récupère la partie supérieure de l'arborescence
     * où les niveaux sont négatifs
     * 
     * @return array $this->tree
     */
    public function getAscendingTree() {
	   $ascTree = array();
	   foreach ($this->tree as $level => $entities) {
		  if ($level <= 0) {
			 $ascTree[$level] = $entities;
		  }
	   }
	   return $ascTree;
    }
    
    /**
     * Récupère la partie inférieure de l'arborescence
     * où les niveaux sont positifs
     * 
     * @return array $this->tree
     */
    public function getDescendingTree() {
	   $descTree = array();
	   foreach ($this->tree as $level => $entities) {
		  if ($level >= 0) {
			 $descTree[$level] = $entities;
		  }
	   }
	   return $descTree;
    }
    
    /** 
     * Récupère les parents directs et non redondants de l'entités
     * 
     * @param object $entity
     * @param object $level
     * 
     * @return array Liste des vrais parents
     */
    public function getTrueParents($entity, $level) {
	   $true_parents = array();
	   foreach($entity->getParents() as $native_parent) {
		  if (isset($this->tree[$level-1])) {
			 foreach($this->tree[$level-1] as $displayed_parent) {
				if ($native_parent->getId() == $displayed_parent->getId()) {
				    $true_parents[] = $native_parent;
				}
			 }
		  }
	   }
	   return $true_parents;
    }
    
    /** 
     * Récupère les enfants directs et non redondants de l'entités
     * 
     * @param object $entity
     * @param object $level
     * 
     * @return array Liste des vrais enfants
     */
    public function getTrueChildren($entity, $level) {
	   $true_children = array();
	   foreach($entity->getChildren() as $native_child) {
		  if (isset($this->tree[$level+1])) {
			 foreach($this->tree[$level+1] as $displayed_child) {
				if ($native_child->getId() == $displayed_child->getId()) {
				    $true_children[] = $native_child;
				}
			 }
		  }
	   }
	   return $true_children;
    }
    
    /** 
     * Récupère les frères directs de l'entités
     * 
     * @param object $entity
     * @param object $level
     * 
     * @return array Liste des vrais frères
     */
    public function getTrueBrothers($entity, $level) {
	   if (isset($this->tree[$level])) {
		  return $this->tree[$level];
	   }
	   return array();
    }
    
    /** 
     * Renvoi le nombre d'entités au dessus de celle envoyée (y compris elle-même)
     * 
     * @param object $entity
     * @param object $level
     * 
     * @return integre Nombre d'entités ascendantes
     */
    public function countNumberOfAscendingEntities($entity, $level) {
	   $involved_entities = array($entity->getId());
	   $count = 1;
	   foreach ($this->tree as $current_level => $entities) {
		  if ($current_level > $level) {
			 foreach ($entities as $current_entity) {
				foreach ($current_entity->getChildren() as $child) {
				    if (in_array($child->getId(), $involved_entities)) {
					   $count++;
					   $involved_entities[] = $current_entity->getId();
				    }
				}
			 }
		  }
	   }
	   return $count;
    }
    
    /** 
     * Renvoi le nombre d'entités au dessous de celle envoyée (y compris elle-même)
     * 
     * @param object $entity
     * @param object $level
     * 
     * @return integre Nombre d'entités descendantes
     */
    public function countNumberOfDescendingEntities($entity, $level) {
	   $involved_entities = array($entity->getId());
	   $count = 1;
	   foreach ($this->tree as $current_level => $entities) {
		  if ($current_level > $level) {
			 foreach ($entities as $current_entity) {
				foreach ($current_entity->getParents() as $parent) {
				    if (in_array($parent->getId(), $involved_entities)) {
					   $count++;
					   $involved_entities[] = $current_entity->getId();
				    }
				}
			 }
		  }
	   }
	   return $count;
    }
    
    /**
     * Définit à true l'entité passée en argument au niveau passé par $level
     * dans l'arbre $treeDisplayed afin de rendre compte de l'avancement de l'affichage de l'arbre
     * 
     * @param type $entity
     * @param type $level
     */
    public function setDisplayed($entity, $level) {
	   $this->treeDisplayed[$level][$entity->getId()] = true;
    }
    
    /**
     * Permet de savoir si l'entité $entity au niveau $level 
     * a déjà été affiché dans l'arbre
     * 
     * @param type $entity
     * @param type $level
     */
    public function isDisplayed($entity, $level) {
	   return $this->treeDisplayed[$level][$entity->getId()];
    }
    
}
