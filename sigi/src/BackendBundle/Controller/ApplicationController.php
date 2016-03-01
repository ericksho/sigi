<?php

namespace BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BackendBundle\Entity\Application;
use BackendBundle\Form\ApplicationType;

/**
 * Application controller.
 *
 * @Route("/application")
 */
class ApplicationController extends Controller
{
    /**
     * Lists all Application entities.
     *
     * @Route("/", name="application_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        switch ($currentUser->getRole()) {
            case 'ROLE_ADMIN':
                $applications = $em->getRepository('BackendBundle:Application')->findAll();
                break;
            case 'ROLE_MENTOR':
                $applications = $em->getRepository('BackendBundle:Application')->findByMentorId($currentUser->getMentor()->getId());
                break;
            case 'ROLE_STUDENT':
                $applications = $em->getRepository('BackendBundle:Application')->findByStudentId($currentUser->getStudent()->getId());
                break;
        }

        

        return $this->render('application/index.html.twig', array(
            'applications' => $applications,
        ));
    }

    /**
     * Creates a new Application entity.
     *
     * @Route("/new", name="application_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        $oportunityId = $this->get('request')->request->get('oportunityId');

        $em = $this->getDoctrine()->getManager();

        if($em->getRepository('BackendBundle:Application')->itExists($currentUser->getStudent()->getId(),$oportunityId))
        {
            $application = $em->getRepository('BackendBundle:Application')->findOneByStudentIdAndOportunityId($currentUser->getStudent()->getId(),$oportunityId);
            return $this->redirectToRoute('application_show', array('id' => $application->getId()));
        }

        $application = new Application();
        $application->setStudent($currentUser->getStudent());

        $studentsName = $currentUser->getStudent()->getNameText();

        if (is_null($oportunityId))
        {
            $oportunityId = $this->get('request')->request->get('oportunityResearch ');
        }
        else
        {
            $oportunity = $em->getRepository('BackendBundle:OportunityResearch')->find($oportunityId);
            $application->setOportunityResearch($oportunity);
        }

        $form = $this->createForm('BackendBundle\Form\ApplicationType', $application, array('choices_array' => array('Aplicado' => 1),'oportunityId' => $oportunityId,'studentId'=>$currentUser->getStudent()->getId()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->flush();

            return $this->redirectToRoute('application_show', array('id' => $application->getId()));
        }

        return $this->render('application/new.html.twig', array(
            'application' => $application,
            'form' => $form->createView(),
            'students_name' => $studentsName,
            'oportunity_name' => $oportunity->getName(),
        ));
    }

    /**
     * Finds and displays a Application entity.
     *
     * @Route("/{id}", name="application_show")
     * @Method("GET")
     */
    public function showAction(Application $application)
    {
        $deleteForm = $this->createDeleteForm($application);

        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        $isMentorOwner = false;
        $isStudentOwner = false;

        if($currentUser->getRole() == "ROLE_MENTOR" && $application->getOportunityResearch()->isMentor($currentUser->getMentor()))
            $isMentorOwner = true;

        if($currentUser->getRole() == "ROLE_STUDENT" && $application->getStudent()->getId() == $currentUser->getStudent()->getId())
            $isStudentOwner = true;

        return $this->render('application/show.html.twig', array(
            'application' => $application,
            'delete_form' => $deleteForm->createView(),
            'is_mentor_owner' => $isMentorOwner,
            'is_student_owner' => $isStudentOwner,
        ));
    }

    /**
     * Changes status to accepted by mentor and displays the application
     *
     * @Route("/{id}/acceptByMentor", name="application_accept_by_mentor")
     * @Method({"GET", "POST"})
     */
    public function acceptByMentorAction(Request $request, Application $application)
    {
        //double check mentor is doing this
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        if($application->getOportunityResearch()->isMentor($currentUser->getMentor()))
        {
            $application->setState(2); //aceptado por el mentor
            $application->setLastUpdateDate(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->flush();
        }

        return $this->redirectToRoute('application_show', array('id' => $application->getId()));
    }

    /**
     * Changes status to accepted by student and displays the application
     *
     * @Route("/{id}/acceptByStudent", name="application_accept_by_student")
     * @Method({"GET", "POST"})
     */
    public function acceptByStudentAction(Request $request, Application $application)
    {
        //double check mentor is doing this
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        if($application->getStudent()->getId() == $currentUser->getStudent()->getId())
        {
            $application->setState(3); //aceptado por el estudiante
            $application->setLastUpdateDate(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->flush();
        }

        return $this->redirectToRoute('application_show', array('id' => $application->getId()));
    }

    /**
     * Displays a form to edit an existing Application entity.
     *
     * @Route("/{id}/edit", name="application_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Application $application)
    {
        $deleteForm = $this->createDeleteForm($application);
        $editForm = $this->createForm('BackendBundle\Form\ApplicationType', $application);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->flush();

            return $this->redirectToRoute('application_edit', array('id' => $application->getId()));
        }

        return $this->render('application/edit.html.twig', array(
            'application' => $application,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Application entity.
     *
     * @Route("/{id}", name="application_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Application $application)
    {
        $form = $this->createDeleteForm($application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($application);
            $em->flush();
        }

        return $this->redirectToRoute('application_index');
    }

    /**
     * Creates a form to delete a Application entity.
     *
     * @param Application $application The Application entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Application $application)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('application_delete', array('id' => $application->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
