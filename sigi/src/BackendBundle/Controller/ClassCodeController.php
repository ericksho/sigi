<?php

namespace BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BackendBundle\Entity\ClassCode;
use BackendBundle\Form\ClassCodeType;

/**
 * ClassCode controller.
 *
 * @Route("/classcode")
 */
class ClassCodeController extends Controller
{
    /**
     * Lists all ClassCode entities.
     *
     * @Route("/", name="class_code_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $classCodes = $em->getRepository('BackendBundle:ClassCode')->findAll();

        return $this->render('classcode/index.html.twig', array(
            'classCodes' => $classCodes,
        ));
    }

    /**
     * Creates a new ClassCode entity.
     *
     * @Route("/new", name="class_code_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $classCode = new ClassCode();
        $form = $this->createForm('BackendBundle\Form\ClassCodeType', $classCode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($classCode);
            $em->flush();

            return $this->redirectToRoute('classcode_show', array('id' => $classCode->getId()));
        }

        return $this->render('classcode/new.html.twig', array(
            'classCode' => $classCode,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ClassCode entity.
     *
     * @Route("/{id}", name="class_code_show")
     * @Method("GET")
     */
    public function showAction(ClassCode $classCode)
    {
        $deleteForm = $this->createDeleteForm($classCode);

        return $this->render('classcode/show.html.twig', array(
            'classCode' => $classCode,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ClassCode entity.
     *
     * @Route("/{id}/edit", name="class_code_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ClassCode $classCode)
    {
        $deleteForm = $this->createDeleteForm($classCode);
        $editForm = $this->createForm('BackendBundle\Form\ClassCodeType', $classCode);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($classCode);
            $em->flush();

            return $this->redirectToRoute('classcode_edit', array('id' => $classCode->getId()));
        }

        return $this->render('classcode/edit.html.twig', array(
            'classCode' => $classCode,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ClassCode entity.
     *
     * @Route("/{id}", name="class_code_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ClassCode $classCode)
    {
        $form = $this->createDeleteForm($classCode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($classCode);
            $em->flush();
        }

        return $this->redirectToRoute('classcode_index');
    }

    /**
     * Creates a form to delete a ClassCode entity.
     *
     * @param ClassCode $classCode The ClassCode entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ClassCode $classCode)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('classcode_delete', array('id' => $classCode->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
