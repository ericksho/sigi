<?php

namespace BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BackendBundle\Entity\Prerequisite;
use BackendBundle\Form\PrerequisiteType;

/**
 * Prerequisite controller.
 *
 * @Route("/prerequisite")
 */
class PrerequisiteController extends Controller
{
    /**
     * Lists all Prerequisite entities.
     *
     * @Route("/", name="prerequisite_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $prerequisites = $em->getRepository('BackendBundle:Prerequisite')->findAll();

        return $this->render('prerequisite/index.html.twig', array(
            'prerequisites' => $prerequisites,
        ));
    }

    /**
     * Creates a new Prerequisite entity.
     *
     * @Route("/new", name="prerequisite_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $prerequisite = new Prerequisite();
        $form = $this->createForm('BackendBundle\Form\PrerequisiteType', $prerequisite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($prerequisite);
            $em->flush();

            return $this->redirectToRoute('prerequisite_show', array('id' => $prerequisite->getId()));
        }

        return $this->render('prerequisite/new.html.twig', array(
            'prerequisite' => $prerequisite,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Prerequisite entity.
     *
     * @Route("/{id}", name="prerequisite_show")
     * @Method("GET")
     */
    public function showAction(Prerequisite $prerequisite)
    {
        $deleteForm = $this->createDeleteForm($prerequisite);

        return $this->render('prerequisite/show.html.twig', array(
            'prerequisite' => $prerequisite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Prerequisite entity.
     *
     * @Route("/{id}/edit", name="prerequisite_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Prerequisite $prerequisite)
    {
        $deleteForm = $this->createDeleteForm($prerequisite);
        $editForm = $this->createForm('BackendBundle\Form\PrerequisiteType', $prerequisite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($prerequisite);
            $em->flush();

            return $this->redirectToRoute('prerequisite_edit', array('id' => $prerequisite->getId()));
        }

        return $this->render('prerequisite/edit.html.twig', array(
            'prerequisite' => $prerequisite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Prerequisite entity.
     *
     * @Route("/{id}", name="prerequisite_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Prerequisite $prerequisite)
    {
        $form = $this->createDeleteForm($prerequisite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($prerequisite);
            $em->flush();
        }

        return $this->redirectToRoute('prerequisite_index');
    }

    /**
     * Creates a form to delete a Prerequisite entity.
     *
     * @param Prerequisite $prerequisite The Prerequisite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Prerequisite $prerequisite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('prerequisite_delete', array('id' => $prerequisite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
