<?php

namespace BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BackendBundle\Entity\EmailList;
use BackendBundle\Form\EmailListType;

/**
 * EmailList controller.
 *
 * @Route("/emaillist")
 */
class EmailListController extends Controller
{
    /**
     * Lists all EmailList entities.
     *
     * @Route("/", name="emaillist_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $emailLists = $em->getRepository('BackendBundle:EmailList')->findAll();

        return $this->render('emaillist/index.html.twig', array(
            'emailLists' => $emailLists,
        ));
    }

    /**
     * Creates a new EmailList entity.
     *
     * @Route("/new", name="emaillist_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $emailList = new EmailList();
        $form = $this->createForm('BackendBundle\Form\EmailListType', $emailList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($emailList);
            $em->flush();

            return $this->redirectToRoute('emaillist_show', array('id' => $emailList->getId()));
        }

        return $this->render('emaillist/new.html.twig', array(
            'emailList' => $emailList,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a EmailList entity.
     *
     * @Route("/{id}", name="emaillist_show")
     * @Method("GET")
     */
    public function showAction(EmailList $emailList)
    {
        $deleteForm = $this->createDeleteForm($emailList);

        return $this->render('emaillist/show.html.twig', array(
            'emailList' => $emailList,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing EmailList entity.
     *
     * @Route("/{id}/edit", name="emaillist_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, EmailList $emailList)
    {
        $deleteForm = $this->createDeleteForm($emailList);
        $editForm = $this->createForm('BackendBundle\Form\EmailListType', $emailList);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($emailList);
            $em->flush();

            return $this->redirectToRoute('emaillist_edit', array('id' => $emailList->getId()));
        }

        return $this->render('emaillist/edit.html.twig', array(
            'emailList' => $emailList,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a EmailList entity.
     *
     * @Route("/{id}", name="emaillist_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, EmailList $emailList)
    {
        $form = $this->createDeleteForm($emailList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($emailList);
            $em->flush();
        }

        return $this->redirectToRoute('emaillist_index');
    }

    /**
     * Creates a form to delete a EmailList entity.
     *
     * @param EmailList $emailList The EmailList entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EmailList $emailList)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('emaillist_delete', array('id' => $emailList->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
