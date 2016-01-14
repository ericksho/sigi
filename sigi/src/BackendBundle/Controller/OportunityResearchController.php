<?php

namespace BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BackendBundle\Entity\OportunityResearch;
use BackendBundle\Form\OportunityResearchType;

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

        $oportunityResearches = $em->getRepository('BackendBundle:OportunityResearch')->findAll();

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
        $oportunityResearch = new OportunityResearch();
        $form = $this->createForm('BackendBundle\Form\OportunityResearchType', $oportunityResearch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($oportunityResearch);
            $em->flush();

            return $this->redirectToRoute('oportunityresearch_show', array('id' => $oportunityresearch->getId()));
        }

        return $this->render('oportunityresearch/new.html.twig', array(
            'oportunityResearch' => $oportunityResearch,
            'form' => $form->createView(),
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
        $deleteForm = $this->createDeleteForm($oportunityResearch);
        $editForm = $this->createForm('BackendBundle\Form\OportunityResearchType', $oportunityResearch);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($oportunityResearch);
            $em->flush();

            return $this->redirectToRoute('oportunityresearch_edit', array('id' => $oportunityResearch->getId()));
        }

        return $this->render('oportunityresearch/edit.html.twig', array(
            'oportunityResearch' => $oportunityResearch,
            'edit_form' => $editForm->createView(),
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
