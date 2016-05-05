<?php

namespace BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BackendBundle\Entity\TimeLimit;
use BackendBundle\Form\TimeLimitType;

/**
 * TimeLimit controller.
 *
 * @Route("/timelimit")
 */
class TimeLimitController extends Controller
{
    /**
     * Lists all TimeLimit entities.
     *
     * @Route("/", name="timelimit_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $timeLimits = $em->getRepository('BackendBundle:TimeLimit')->findAll();

        return $this->render('timelimit/index.html.twig', array(
            'timeLimits' => $timeLimits,
        ));
    }

    /**
     * Creates a new TimeLimit entity.
     *
     * @Route("/new", name="timelimit_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $timeLimit = new TimeLimit();
        $form = $this->createForm('BackendBundle\Form\TimeLimitType', $timeLimit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($timeLimit);
            $em->flush();

            return $this->redirectToRoute('timelimit_show', array('id' => $timeLimit->getId()));
        }

        return $this->render('timelimit/new.html.twig', array(
            'timeLimit' => $timeLimit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TimeLimit entity.
     *
     * @Route("/{id}", name="timelimit_show")
     * @Method("GET")
     */
    public function showAction(TimeLimit $timeLimit)
    {
        $deleteForm = $this->createDeleteForm($timeLimit);

        return $this->render('timelimit/show.html.twig', array(
            'timeLimit' => $timeLimit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TimeLimit entity.
     *
     * @Route("/{id}/edit", name="timelimit_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TimeLimit $timeLimit)
    {
        $deleteForm = $this->createDeleteForm($timeLimit);
        $editForm = $this->createForm('BackendBundle\Form\TimeLimitType', $timeLimit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($timeLimit);
            $em->flush();

            return $this->redirectToRoute('timelimit_edit', array('id' => $timeLimit->getId()));
        }

        return $this->render('timelimit/edit.html.twig', array(
            'timeLimit' => $timeLimit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TimeLimit entity.
     *
     * @Route("/{id}", name="timelimit_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TimeLimit $timeLimit)
    {
        $form = $this->createDeleteForm($timeLimit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($timeLimit);
            $em->flush();
        }

        return $this->redirectToRoute('timelimit_index');
    }

    /**
     * Creates a form to delete a TimeLimit entity.
     *
     * @param TimeLimit $timeLimit The TimeLimit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TimeLimit $timeLimit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('timelimit_delete', array('id' => $timeLimit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
