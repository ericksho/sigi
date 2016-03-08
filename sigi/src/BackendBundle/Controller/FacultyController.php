<?php

namespace BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BackendBundle\Entity\Faculty;
use BackendBundle\Form\FacultyType;

/**
 * Faculty controller.
 *
 */
class FacultyController extends Controller
{
    /**
     * Lists all Faculty entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $faculties = $em->getRepository('BackendBundle:Faculty')->findAll();

        return $this->render('faculty/index.html.twig', array(
            'faculties' => $faculties,
        ));
    }

    /**
     * Creates a new Faculty entity.
     *
     */
    public function newAction(Request $request)
    {
        $faculty = new Faculty();
        $form = $this->createForm('BackendBundle\Form\FacultyType', $faculty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($faculty);
            $em->flush();

            return $this->redirectToRoute('faculty_show', array('id' => $faculty->getId()));
        }

        return $this->render('faculty/new.html.twig', array(
            'faculty' => $faculty,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Faculty entity.
     *
     */
    public function showAction(Faculty $faculty)
    {
        $deleteForm = $this->createDeleteForm($faculty);

        return $this->render('faculty/show.html.twig', array(
            'faculty' => $faculty,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Faculty entity.
     *
     */
    public function editAction(Request $request, Faculty $faculty)
    {
        $deleteForm = $this->createDeleteForm($faculty);
        $editForm = $this->createForm('BackendBundle\Form\FacultyType', $faculty);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($faculty);
            $em->flush();

            return $this->redirectToRoute('faculty_edit', array('id' => $faculty->getId()));
        }

        return $this->render('faculty/edit.html.twig', array(
            'faculty' => $faculty,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Faculty entity.
     *
     */
    public function deleteAction(Request $request, Faculty $faculty)
    {
        $form = $this->createDeleteForm($faculty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($faculty);
            $em->flush();
        }

        return $this->redirectToRoute('faculty_index');
    }

    /**
     * Creates a form to delete a Faculty entity.
     *
     * @param Faculty $faculty The Faculty entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Faculty $faculty)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('faculty_delete', array('id' => $faculty->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
