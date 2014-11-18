<?php

namespace Ico\Bundle\RulesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class SpellsController extends Controller
{
    /**
     * @Route("/règles-pathfinder/sorts", name="ico_rules_spells")
     * @Template()
     */
    public function indexAction(Request $request)
    {	   	   	   
	   $filter = $this->createFormBuilder()
			 ->setMethod('GET')
			 ->add('keywords', 'text', array('label' => 'Mots-clés', 'required' => false, 'attr' => array('placeholder' => 'Entrez un ou plusieurs séparés par des virgules')))
			 ->add('spellSchool', 'entity', array(
				'class' => 'IcoRulesBundle:SpellSchool',
				'property' => 'name',
				'label' => 'École', 
				'required' => false,
				'expanded'  => false
			 ))
			 ->add('spellLevel', 'choice', array(
				'label' => 'Niveau', 
				'choices' => array(
				    10 => '',
				    0 => '0',
				    1 => '1',
				    2 => '2',
				    3 => '3',
				    4 => '4',
				    5 => '5',
				    6 => '6',
				    7 => '7',
				    8 => '8',
				    9 => '9'
				),
				'empty_value' => false,
				'required' => false
			 ))
			 ->add('spellList', 'entity', array(
				'class' => 'IcoRulesBundle:SpellList',
				'property' => 'name',
				'label' => 'Liste de sorts', 
				'required' => false,
				'expanded'  => false
			 ))
			 ->getForm();
	   $filter->handleRequest($request);
	   
	   $queryBuilder = $this->getDoctrine()
			 ->getRepository('IcoRulesBundle:Spell')
			 ->createQueryBuilder('spell')
			 ->leftJoin('spell.spellSchool', 'spellSchool')
			 ->leftJoin('spell.spellListsLevels', 'spellListsLevels');
	   $parameters = array();
	   
	   if ($filter->isValid()) {
		  $data = $filter->getData();
		  if (!empty($data['spellList'])) {
			 $queryBuilder->andWhere('spellListsLevels.spellList = :spellList');
			 $parameters['spellList'] = $data['spellList']->getId();
		  }	
		  if ($data['spellLevel'] != 10) {
			 $queryBuilder->andWhere('spellListsLevels.level = :spellLevel');
			 $parameters['spellLevel'] = $data['spellLevel'];
		  }	
		  if (!empty($data['spellSchool'])) {
			 $queryBuilder->andWhere('spellSchool.id = :spellSchool');
			 $parameters['spellSchool'] = $data['spellSchool']->getId();
		  }		  
		  if (!empty($data['keywords'])) {
			 $keywords = explode(',', $data['keywords']);
			 $where = array();
			 foreach ($keywords as $key => $keyword) {
				$keyword = trim($keyword);
				$where[] = '(spell.name LIKE :name'.$key.' OR spell.description LIKE :description'.$key.')';
				$parameters['name'.$key] = '%'.$keyword.'%';
				$parameters['description'.$key] = '%'.$keyword.'%';
			 }
			 $queryBuilder->andWhere(implode(' OR ', $where));
		  }
	   }	   
	   
	   $queryBuilder->orderBy('spell.name', 'ASC');
	   $queryBuilder->setParameters($parameters);
	   
	   $pagination = $this->get('knp_paginator')->paginate(
		   $queryBuilder->getQuery(), $this->get('request')->query->get('page', 1) /* page number */, 50 /* limit per page */
	   );
	   
	   if (count($pagination) == 0) {
		  $this->get('session')->getFlashBag()->add('warning', 'Aucun sort ne correspond à vos critères.');
	   }
	   
        return $this->render('IcoRulesBundle:Spells:index.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles' => 'ico_rules', 
			 'Sorts' => 'ico_rules_spells'
		  ),
		  'title' => 'Sorts',
		  'subtitle' => 'Liste',
		  'pagination' => $pagination,
		  'filter' => $filter->createView()
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder/sorts/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_spell_view", options={"expose"=true})
     * @Template()
     */
    public function viewAction($id)
    {
	   $spell = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:Spell')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:Spells:view.html.twig', array(
		  'breadcrumb' => array(
			 'Accueil' => 'ico', 
			 'Règles' => 'ico_rules', 
			 'Sorts' => 'ico_rules_spells',
			 $spell->getName() => ''
		  ),
		  'title' => 'Sort',
		  'subtitle' => $spell->getName(),
		  'spell' => $spell
	   ));
    }
    
    /**
     * @Route("/règles-pathfinder-aperçu/sorts/{id}/{slug}", requirements={"id"="\d+"}, defaults={"slug"=false}, name="ico_rules_spellt_preview", options={"expose"=true})
     * @Template()
     */
    public function previewAction($id)
    {
	   $spell = $this->getDoctrine()
		  ->getRepository('IcoRulesBundle:Spell')
		  ->find($id);
	   
        return $this->render('IcoRulesBundle:Spells:preview.html.twig', array(
		  'spell' => $spell
	   ));
    }
}
