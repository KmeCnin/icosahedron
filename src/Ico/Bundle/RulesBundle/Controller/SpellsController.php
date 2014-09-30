<?php

namespace Ico\Bundle\RulesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class SpellsController extends Controller
{
    /**
     * @Route("/rules/spells", name="ico_rules_spells")
     * @Template()
     */
    public function indexAction(Request $request)
    {	   	   
//	   $featprerequisites = $this->getDoctrine()
//		  ->getRepository('IcoRulesBundle:FeatPrerequisite')
//		  ->findAll();
	   
	   $filter = $this->createFormBuilder()
			 ->add('name', 'text', array('label' => 'Don', 'required' => false, 'attr' => array('placeholder' => 'Mots-clés')))
			 ->add('featTypes', 'entity', array(
				'class' => 'IcoRulesBundle:FeatType',
				'property' => 'name',
				'label' => 'Catégories', 
				'required' => false,
				'expanded'  => false,
				'multiple'  => true
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
			 ->add('description', 'text', array('label' => 'Description', 'required' => false, 'attr' => array('placeholder' => 'Mots-clés')))
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
		  if (!empty($data['name'])) {
			 $keywords = explode(' ', $data['name']);
			 foreach ($keywords as $key => $keyword) {
				$queryBuilder->orWhere('feat.name LIKE :name'.$key);
				$parameters['name'.$key] = '%'.$keyword.'%';
			 }
		  }
		  if (!empty($data['description'])) {
			 $keywords = explode(' ', $data['description']);
			 foreach ($keywords as $key => $keyword) {
				$queryBuilder->orWhere('feat.description LIKE :description'.$key);
				$parameters['description'.$key] = '%'.$keyword.'%';
			 }
		  }
	   }	   
	   
	   $queryBuilder->setParameters($parameters);
//		  var_dump($queryBuilder->getQuery());
	   
	   $pagination = $this->get('knp_paginator')->paginate(
		   $queryBuilder->getQuery(), $this->get('request')->query->get('page', 1) /* page number */, 50 /* limit per page */
	   );
	   
	   if (count($pagination) == 0) {
		  $this->get('session')->getFlashBag()->add('warning', 'Aucun don ne correspond à vos critères.');
	   }
	   
        return $this->render('IcoRulesBundle:Feats:index.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles' => 'ico_rules', 
			 'Dons' => 'ico_rules_feats'
		  ),
		  'title' => 'Dons',
		  'subtitle' => 'Liste',
//		  'featprerequisites' => $featprerequisites,
		  'pagination' => $pagination,
		  'filter' => $filter->createView()
	   ));
    }
    
    /**
     * @Route("/rules/feat/view/{id}", name="ico_rules_feat_view", options={"expose"=true})
     * @Template()
     */
    public function viewAction($id)
    {
	   $feat = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:Feat')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:Feats:view.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles' => 'ico_rules', 
			 'Dons' => 'ico_rules_feats',
			 $feat->getName() => ''
		  ),
		  'title' => 'Don',
		  'subtitle' => $feat->getName(),
		  'feat' => $feat
	   ));
    }
    
    /**
     * @Route("/rules/feat/preview/{id}", name="ico_rules_feat_preview", options={"expose"=true})
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
