<?php

namespace Ico\Bundle\RulesBundle\Controller;

use Ico\Bundle\RulesBundle\Helper\TrueTreeHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FeatsController extends Controller
{
    /**
     * @Route("/règles-pathfinder/dons", name="ico_rules_feats")
     * @Template()
     */
    public function indexAction(Request $request)
    {	   	   	   
	   $filter = $this->createFormBuilder()
			 ->setMethod('GET')
			 ->add('keywords', 'text', array('label' => 'Mots-clés', 'required' => false, 'attr' => array('placeholder' => 'Entrez un ou plusieurs séparés par des virgules')))
			 ->add('featTypes', 'entity', array(
				'class' => 'IcoRulesBundle:FeatType',
				'property' => 'name',
				'label' => 'Catégories', 
				'required' => false,
				'expanded'  => false,
				'multiple' => true
			 ))
			 ->add('featTypesType', 'choice', array(
				'choices' => array(
				    'or' => 'Contien au moins une',
				    'and' => 'Contien toutes',
				    'not' => 'Ne contien aucune'
				),
				'empty_value' => false,
				'required' => false
			 ))
			 ->getForm();
	   $filter->handleRequest($request);
	   
	   $queryBuilder = $this->getDoctrine()
			 ->getRepository('IcoRulesBundle:Feat')
			 ->createQueryBuilder('feat');
	   $parameters = array();
	   
	   if ($filter->isValid()) {
		  $data = $filter->getData();
		  if ($data['featTypesType'] == 'or') {
			 
			 $queryBuilder->leftJoin('feat.featTypes', 'type');
			 foreach ($data['featTypes'] as $key => $type) {
				$queryBuilder->orWhere('type.id = :type'.$key);
				$parameters['type'.$key] = $type;
			 }
			 
		  } elseif ($data['featTypesType'] == 'and') {
			 
			 $queryBuilder->leftJoin('feat.featTypes', 'type');
			 $where = array();
			 foreach ($data['featTypes'] as $key => $type) {
				$where[] = ':type'.$key.' MEMBER OF feat.featTypes';
				$parameters['type'.$key] = $type;
			 }
			 $queryBuilder->andWhere(implode(' AND ', $where));
			 
		  } elseif ($data['featTypesType'] == 'not') {
			 
			 $queryBuilder->leftJoin('feat.featTypes', 'type');
			 $where = array();
			 foreach ($data['featTypes'] as $key => $type) {
				$where[] = ':type'.$key.' NOT MEMBER OF feat.featTypes';
				$parameters['type'.$key] = $type;
			 }
			 $queryBuilder->andWhere(implode(' AND ', $where));
			 
		  }
		  if (!empty($data['keywords'])) {
			 $keywords = explode(',', $data['keywords']);
			 $where = array();
			 foreach ($keywords as $key => $keyword) {
				$keyword = trim($keyword);
				$where[] = '(feat.name LIKE :name'.$key.' OR feat.description LIKE :description'.$key.' OR feat.benefit LIKE :benefit'.$key.')';
				$parameters['name'.$key] = '%'.$keyword.'%';
				$parameters['description'.$key] = '%'.$keyword.'%';
				$parameters['benefit'.$key] = '%'.$keyword.'%';
			 }
			 $queryBuilder->andWhere(implode(' OR ', $where));
		  }
	   }	   
	   
	   $queryBuilder->orderBy('feat.name', 'ASC');
	   $queryBuilder->setParameters($parameters);
//		  var_dump($queryBuilder->getQuery());
	   
	   $pagination = $this->get('knp_paginator')->paginate(
		   $queryBuilder->getQuery(), $this->get('request')->query->get('page', 1) /* page number */, 50 /* limit per page */
	   );
	   
	   $tree = array();
	   if (count($pagination) == 0) {
		  $this->get('session')->getFlashBag()->add('warning', 'Aucun don ne correspond à vos critères.');
	   } else {
		  // Récupération de l'arborescence de chaque don
		  foreach ($pagination as $feat) {
			 $trueTree = new TrueTreeHelper($feat);
			 $tree[$feat->getId()] = $trueTree;
		  }
	   }
	   
        return $this->render('IcoRulesBundle:Feats:index.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles Pathfinder' => 'ico_rules', 
			 'Dons' => 'ico_rules_feats'
		  ),
		  'title' => 'Dons',
		  'subtitle' => 'Liste',
//		  'featprerequisites' => $featprerequisites,
		  'pagination' => $pagination,
		  'filter' => $filter->createView(),
		  'tree' => $tree
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder/dons/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_feat_view", options={"expose"=true})
     * @Template()
     */
    public function viewAction($id)
    {
	   $feat = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:Feat')
		  ->find($id);
	   
	   $trueTree = new TrueTreeHelper($feat);
	   
        return $this->render('IcoRulesBundle:Feats:view.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles Pathfinder' => 'ico_rules', 
			 'Dons' => 'ico_rules_feats',
			 $feat->getName() => ''
		  ),
		  'title' => 'Don',
		  'subtitle' => $feat->getName(),
		  'feat' => $feat,
		  'tree' => $trueTree
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder-aperçu/dons/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_feat_preview", options={"expose"=true})
     * @Template()
     */
    public function previewAction($id)
    {
	   $feat = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:Feat')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:Feats:preview.html.twig', array(
		  'feat' => $feat
	   ));
    }
}
