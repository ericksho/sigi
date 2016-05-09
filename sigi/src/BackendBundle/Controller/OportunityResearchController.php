<?php

namespace BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BackendBundle\Entity\OportunityResearch;
use BackendBundle\Form\OportunityResearchType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use BackendBundle\Entity\Keyword;

/**
 * OportunityResearch controller.
 *
 * @Route("/oportunityresearch")
 */
class OportunityResearchController extends Controller
{
    /**
     * Lists all OportunityResearch entities.
     *
     * @Route("/", name="oportunityresearch_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        $id = $currentUser->getId();

        $oportunityResearches = $em->getRepository('BackendBundle:OportunityResearch')->findOportunitiesByUserId($id);

        return $this->render('oportunityresearch/index.html.twig', array(
            'oportunityResearches' => $oportunityResearches,
        ));
    }

    /**
     * Search and Lists all OportunityResearch Searches.
     *
     * @Route("/search", name="oportunityresearch_search")
     * @Method({"GET", "POST"})
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $name = $request->query->get('name');

        $oportunityResearches = $em->getRepository('BackendBundle:OportunityResearch')->findOportunitiesByName($name);

        $keyword = $request->query->get('keyword');
        if (!is_null($keyword))
            $oportunityResearches = $em->getRepository('BackendBundle:OportunityResearch')->findOportunitiesByKeyword($keyword);

        $prerequisite = $request->query->get('prerequisite');
        if (!is_null($prerequisite))
            $oportunityResearches = $em->getRepository('BackendBundle:OportunityResearch')->findOportunitiesByPrerequisite($prerequisite);

        $mentor = $request->query->get('mentor');
        if (!is_null($mentor))
            $oportunityResearches = $em->getRepository('BackendBundle:OportunityResearch')->findOportunitiesByMentorId($mentor);

        $defaultData = array('message' => 'Type your message here');
        $advancedForm = $this->createFormBuilder($defaultData)
            ->add('creationDate1', 'date', array('widget' => 'single_text', 'attr' => array('class'=>'form-control'), 'label' => 'Creado después del', 'required' => false,))
            ->add('creationDate2', 'date', array('widget' => 'single_text', 'attr' => array('class'=>'form-control'), 'label' => 'Creado antes del', 'required' => false,))
            ->add('name', null,array('label' => 'Nombre','attr' => array('class'=>'form-control', 'placeholder' => 'Nombre de la Oportunidad',), 'required' => false))
            ->add('description', null,array('label' => 'Descripción','attr' => array('class'=>'form-control', 'placeholder' => 'Descripción de la Oportunidad',), 'required' => false))
            ->add('modality', ChoiceType::class,array('choices'  => array(1 => 'Nota 1-7', 2 => 'Alfa numerico'),'label' => 'Método de evaluación','attr' => array('class'=>'form-control'), 'required' => false))
            ->add('oportunityKeywords', EntityType::class, array(
                'label' => 'Keywords',
                'required' => false,
                'class' => 'BackendBundle:Keyword',
                'multiple' => true,
                'attr' => array('class'=>'js-tokenizer'),
                'choice_label' => 'keyword',))
            ->add('prerequisites', EntityType::class, array(
                'label' => 'Prerequisitos',
                'required' => false,
                'class' => 'BackendBundle:Prerequisite',
                'multiple' => true,
                'attr' => array('class'=>'js-tokenizer'),
                'choice_label' => 'courseNumber',))
            ->add('mentors', EntityType::class, array(
                'label' => 'Mentores',
                'required' => false,
                'class' => 'BackendBundle:Mentor',
                'multiple' => true,
                'attr' => array('class'=>'js-tokenizer'),
                'choice_label' => 'getShowName',))
            ->add('sort', ChoiceType::class,array('choices'  => array(
                    'creationDate' => 'Fecha de creación', 
                    'name' => 'Nombre',
                    'description' => 'Descripción',
                ), 
            'data' => 'creationDate',
                'label' => 'Ordenar por','attr' => array('class'=>'form-control'), 'required' => false))
            ->add('order', HiddenType::class, array('data' => 'ASC',))
            ->add('submit', 'submit', array('label' => 'Buscar', 'attr' => array('class'=>"btn btn-default")))
            ->getForm();
     
        $advancedForm->handleRequest($request);

        if ($advancedForm->isSubmitted() && $advancedForm->isValid()) 
        {
            $oportunityResearches = $em->getRepository('BackendBundle:OportunityResearch')->searchFromForm($advancedForm);
        } 

        return $this->render('oportunityresearch/search.html.twig', array(
            'oportunityResearches' => $oportunityResearches,
            'advancedForm' => $advancedForm->createView(),
        ));
    }

    /**
     * Lists all OportunityResearch Applications.
     *
     * @Route("/applications/{id}", name="oportunityresearch_applications")
     * @Method("GET")
     */
    public function applicationsAction(OportunityResearch $oportunityResearch)
    {
        $em = $this->getDoctrine()->getManager();

        $applications = $oportunityResearch->getApplications();

        return $this->render('oportunityresearch/applications.html.twig', array(
            'applications' => $applications,
        ));
    }

    /**
     * Creates a new OportunityResearch entity.
     *
     * @Route("/new", name="oportunityresearch_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        $oportunityResearch = new OportunityResearch();

        $oportunityResearch->setDepartment($currentUser->getMentor()->getDepartment());

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new OportunityResearchType($em), $oportunityResearch);
        $form->handleRequest($request);

        $mentorFacutly = $em->getRepository('BackendBundle:OportunityResearch')->findMentorFaculties();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $oportunityResearch->setMainMentor($currentUser->getMentor());
            $em->persist($oportunityResearch);
            $em->flush();

            return $this->redirectToRoute('oportunityresearch_show', array('id' => $oportunityResearch->getId()));
        }

        return $this->render('oportunityresearch/new.html.twig', array(
            'oportunityResearch' => $oportunityResearch,
            'form' => $form->createView(),
            'mentorFacutly' => $mentorFacutly,
            'currentMentorId' => $currentUser->getMentor()->getId(),
        ));
    }

    /**
     * Finds and displays a OportunityResearch entity.
     *
     * @Route("/{id}", name="oportunityresearch_show")
     * @Method("GET")
     */
    public function showAction(OportunityResearch $oportunityResearch)
    {
        $deleteForm = $this->createDeleteForm($oportunityResearch);
        $em = $this->getDoctrine()->getManager();

        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        $vacants = $oportunityResearch->getOpenVacants();

        $owner = $oportunityResearch->isOwner($currentUser);

        return $this->render('oportunityresearch/show.html.twig', array(
            'oportunityResearch' => $oportunityResearch,
            'delete_form' => $deleteForm->createView(),
            'owner' => $owner,
            'vacants' => $vacants,
        ));
    }

    /**
     * Displays a form to edit an existing OportunityResearch entity.
     *
     * @Route("/{id}/edit", name="oportunityresearch_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, OportunityResearch $oportunityResearch)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        
        $deleteForm = $this->createDeleteForm($oportunityResearch);
        $em = $this->getDoctrine()->getManager();
        $editForm = $this->createForm(new OportunityResearchType($em), $oportunityResearch);
        $editForm->handleRequest($request);

        $mentorFacutly = $em->getRepository('BackendBundle:OportunityResearch')->findMentorFaculties();

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em = $this->getDoctrine()->getManager();

            //agregar keywords a la oportunidad
            

            $em->persist($oportunityResearch);
            $em->flush();

            return $this->redirectToRoute('oportunityresearch_edit', array('id' => $oportunityResearch->getId()));
        }

        return $this->render('oportunityresearch/edit.html.twig', array(
            'oportunityResearch' => $oportunityResearch,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'mentorFacutly' => $mentorFacutly,
            'currentMentorId' => $currentUser->getMentor()->getId(),
        ));
    }

    /**
     * Deletes a OportunityResearch entity.
     *
     * @Route("/{id}", name="oportunityresearch_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, OportunityResearch $oportunityResearch)
    {
        $form = $this->createDeleteForm($oportunityResearch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($oportunityResearch);
            $em->flush();
        }

        return $this->redirectToRoute('oportunityresearch_index');
    }

    /**
     * Creates a form to delete a OportunityResearch entity.
     *
     * @param OportunityResearch $oportunityResearch The OportunityResearch entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(OportunityResearch $oportunityResearch)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('oportunityresearch_delete', array('id' => $oportunityResearch->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
