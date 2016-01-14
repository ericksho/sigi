<?php

namespace BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BackendBundle\Entity\Requirement;
use BackendBundle\Form\RequirementType;

/**
 * Requirement controller.
 *
 * @Route("/requirement")
 */
class RequirementController extends Controller
{
    /**
     * Lists all Requirement entities.
     *
     * @Route("/", name="requirement_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $requirements = $em->getRepository('BackendBundle:Requirement')->findAll();

        return $this->render('requirement/index.html.twig', array(
            'requirements' => $requirements,
        ));
    }

    /**
     * Creates a new Requirement entity.
     *
     * @Route("/new", name="requirement_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $requirement = new Requirement();
        $form = $this->createForm('BackendBundle\Form\RequirementType', $requirement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($requirement);
            $em->flush();

            return $this->redirectToRoute('requirement_show', array('id' => $requirement->getId()));
        }

        return $this->render('requirement/new.html.twig', array(
            'requirement' => $requirement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Requirement entity.
     *
     * @Route("/{id}", name="requirement_show")
     * @Method("GET")
     */
    public function showAction(Requirement $requirement)
    {
        $deleteForm = $this->createDeleteForm($requirement);

        return $this->render('requirement/show.html.twig', array(
            'requirement' => $requirement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Requirement entity.
     *
     * @Route("/{id}/edit", name="requirement_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Requirement $requirement)
    {
        $deleteForm = $this->createDeleteForm($requirement);
        $editForm = $this->createForm('BackendBundle\Form\RequirementType', $requirement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($requirement);
            $em->flush();

            return $this->redirectToRoute('requirement_edit', array('id' => $requirement->getId()));
        }

        return $this->render('requirement/edit.html.twig', array(
            'requirement' => $requirement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Requirement entity.
     *
     * @Route("/{id}", name="requirement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Requirement $requirement)
    {
        $form = $this->createDeleteForm($requirement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($requirement);
            $em->flush();
        }

        return $this->redirectToRoute('requirement_index');
    }

    /**
     * Creates a form to delete a Requirement entity.
     *
     * @param Requirement $requirement The Requirement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Requirement $requirement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('requirement_delete', array('id' => $requirement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
