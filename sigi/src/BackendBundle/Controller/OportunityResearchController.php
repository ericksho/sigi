<?php

namespace BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BackendBundle\Entity\OportunityResearch;
use BackendBundle\Form\OportunityResearchType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
     * Creates a new OportunityResearch entity.
     *
     * @Route("/new", name="oportunityresearch_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        $oportunityResearch = new OportunityResearch();

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new OportunityResearchType($em), $oportunityResearch);
        $form->handleRequest($request);

        $secondaryForm = $this->createForm('BackendBundle\Form\SecondaryMentorType', $oportunityResearch, array('current_id'=>$currentUser->getId()));
        $secondaryForm->handleRequest($request);

        $thertiaryForm = $this->createForm('BackendBundle\Form\ThertiaryMentorType', $oportunityResearch, array('current_id'=>$currentUser->getId()));
        $thertiaryForm->handleRequest($request);

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
            'secondaryForm' => $secondaryForm->createView(),
            'thertiaryForm' => $thertiaryForm-> createView(),
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

        return $this->render('oportunityresearch/show.html.twig', array(
            'oportunityResearch' => $oportunityResearch,
            'delete_form' => $deleteForm->createView(),
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

        $secondaryForm = $this->createForm('BackendBundle\Form\SecondaryMentorType', $oportunityResearch, array('current_id'=>$currentUser->getId()));
        $secondaryForm->handleRequest($request);

        $thertiaryForm = $this->createForm('BackendBundle\Form\ThertiaryMentorType', $oportunityResearch, array('current_id'=>$currentUser->getId()));
        $thertiaryForm->handleRequest($request);

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
            'secondaryForm' => $secondaryForm->createView(),
            'thertiaryForm' => $thertiaryForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
