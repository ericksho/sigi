<?php

namespace BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BackendBundle\Entity\Deadline;
use BackendBundle\Form\DeadlineType;

/**
 * Deadline controller.
 *
 * @Route("/deadline")
 */
class DeadlineController extends Controller
{
    /**
     * Lists all Deadline entities.
     *
     * @Route("/", name="deadline_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $deadlines = $em->getRepository('BackendBundle:Deadline')->findAll();

        return $this->render('deadline/index.html.twig', array(
            'deadlines' => $deadlines,
        ));
    }

    /**
     * Creates a new Deadline entity.
     *
     * @Route("/new", name="deadline_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $deadline = new Deadline();
        $form = $this->createForm('BackendBundle\Form\DeadlineType', $deadline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($deadline);
            $em->flush();

            return $this->redirectToRoute('deadline_show', array('id' => $deadline->getId()));
        }

        return $this->render('deadline/new.html.twig', array(
            'deadline' => $deadline,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Deadline entity.
     *
     * @Route("/{id}", name="deadline_show")
     * @Method("GET")
     */
    public function showAction(Deadline $deadline)
    {
        $deleteForm = $this->createDeleteForm($deadline);

        return $this->render('deadline/show.html.twig', array(
            'deadline' => $deadline,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Deadline entity.
     *
     * @Route("/{id}/edit", name="deadline_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Deadline $deadline)
    {
        $deleteForm = $this->createDeleteForm($deadline);
        $editForm = $this->createForm('BackendBundle\Form\DeadlineType', $deadline);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($deadline);
            $em->flush();

            return $this->redirectToRoute('deadline_edit', array('id' => $deadline->getId()));
        }

        return $this->render('deadline/edit.html.twig', array(
            'deadline' => $deadline,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Deadline entity.
     *
     * @Route("/{id}", name="deadline_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Deadline $deadline)
    {
        $form = $this->createDeleteForm($deadline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($deadline);
            $em->flush();
        }

        return $this->redirectToRoute('deadline_index');
    }

    /**
     * Creates a form to delete a Deadline entity.
     *
     * @param Deadline $deadline The Deadline entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Deadline $deadline)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('deadline_delete', array('id' => $deadline->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
