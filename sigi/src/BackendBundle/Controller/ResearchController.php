<?php

namespace BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BackendBundle\Entity\Research;
use BackendBundle\Form\ResearchType;

/**
 * Research controller.
 *
 * @Route("/research")
 */
class ResearchController extends Controller
{
    /**
     * Lists all Research entities.
     *
     * @Route("/", name="research_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $researches = $em->getRepository('BackendBundle:Research')->findAll();

        return $this->render('research/index.html.twig', array(
            'researches' => $researches,
        ));
    }

    /**
     * Creates a new Research entity.
     *
     * @Route("/new", name="research_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $research = new Research();
        $form = $this->createForm('BackendBundle\Form\ResearchType', $research);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($research);
            $em->flush();

            return $this->redirectToRoute('research_show', array('id' => $research->getId()));
        }

        return $this->render('research/new.html.twig', array(
            'research' => $research,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Research entity.
     *
     * @Route("/{id}", name="research_show")
     * @Method("GET")
     */
    public function showAction(Research $research)
    {
        $deleteForm = $this->createDeleteForm($research);

        return $this->render('research/show.html.twig', array(
            'research' => $research,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Research entity.
     *
     * @Route("/{id}/edit", name="research_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Research $research)
    {
        $deleteForm = $this->createDeleteForm($research);
        $editForm = $this->createForm('BackendBundle\Form\ResearchType', $research);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($research);
            $em->flush();

            return $this->redirectToRoute('research_edit', array('id' => $research->getId()));
        }

        return $this->render('research/edit.html.twig', array(
            'research' => $research,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Research entity.
     *
     * @Route("/{id}", name="research_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Research $research)
    {
        $form = $this->createDeleteForm($research);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($research);
            $em->flush();
        }

        return $this->redirectToRoute('research_index');
    }

    /**
     * Creates a form to delete a Research entity.
     *
     * @param Research $research The Research entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Research $research)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('research_delete', array('id' => $research->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
