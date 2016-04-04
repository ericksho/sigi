<?php

namespace BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BackendBundle\Entity\Application;
use BackendBundle\Form\ApplicationType;
use BackendBundle\Entity\Notification;
use BackendBundle\Entity\Research;

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

        if (is_null($oportunityId))
        {
            $app = $this->get('request')->request->get('application');
            $oportunityId = $app['oportunityResearch'];
        }
        else
        {
            $oportunity = $em->getRepository('BackendBundle:OportunityResearch')->find($oportunityId);
            $application->setOportunityResearch($oportunity);
        }

        $form = $this->createForm('BackendBundle\Form\ApplicationType', $application, array('choices_array' => array('Aplicando' => 1),'oportunityId' => $oportunityId,'studentId'=>$currentUser->getStudent()->getId()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //notificacion de systema a mentor
            $notification1 = new Notification();
            $mentor = $application->getOportunityResearch()->getMainMentor();
            $reciever = $mentor->getUser();
            $message = "Un nuevo alumno ha postulado a su oportunidad de investigación: ".$application->getOportunityResearch()->getName().
            " porfavor pongase en contacto con el para coordinar su reunión.".
            '@<'.$currentUser->getId().'>@';
            $notification1->sendSystemMessage($reciever, $message);  

            //notificacion de systema a estudiante
            $notification2 = new Notification();
            $reciever = $application->getStudent()->getUser();
            $message = "Felicitaciones, su postulación a la oportunidad de investigación: ".$application->getOportunityResearch()->getName()." ah sido ingresada y notifiacada al mentor, este se pondrá en contacto con usted para coordinar su reunión";
            $notification2->sendSystemMessage($reciever, $message);  

            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->persist($notification1);
            $em->persist($notification2);
            $em->flush();

            return $this->redirectToRoute('application_show', array('id' => $application->getId()));
        }

        return $this->render('application/new.html.twig', array(
            'application' => $application,
            'form' => $form->createView(),
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

            $notification = new Notification();
            $sender = $currentUser;
            $reciever = $application->getStudent()->getUser();
            $message = "Felicitaciones, su aplicacion a la oportunidad ".$application->getOportunityResearch()->getName()." ah sido aceptada";
            $notification->sendNotification($sender, $reciever, $message);

            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->persist($notification);
            $em->flush();
        }

        return $this->redirectToRoute('application_show', array('id' => $application->getId()));
    }

    /**
     * Changes status to not accepted by mentor and displays the application
     *
     * @Route("/{id}/notSelectedByMentor", name="application_not_selected_by_mentor")
     * @Method({"GET", "POST"})
     */
    public function notSelectedByMentorAction(Request $request, Application $application)
    {
        //double check mentor is doing this
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        if($application->getOportunityResearch()->isMentor($currentUser->getMentor()))
        {
            $application->setState(6); //no seleccionado por el mentor
            $application->setLastUpdateDate(new \DateTime());

            $notification = new Notification();
            $sender = $currentUser;
            $reciever = $application->getStudent()->getUser();
            $message = "Lamentamos comunicarle que su aplicacion a la oportunidad ".$application->getOportunityResearch()->getName()." no ah sido aceptada";
            $notification->sendNotification($sender, $reciever, $message);

            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->persist($notification);
            $em->flush();
        }

        return $this->redirectToRoute('application_show', array('id' => $application->getId()));
    }

    /**
     * Changes status to not accepted by student and displays the application
     *
     * @Route("/{id}/notAcceptByStudent", name="application_not_accept_by_student")
     * @Method({"GET", "POST"})
     */
    public function notAcceptByStudentAction(Request $request, Application $application)
    {
        //double check mentor is doing this
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        if($application->getStudent()->getId() == $currentUser->getStudent()->getId())
        {
            $application->setState(7); //aceptado por el estudiante
            $application->setLastUpdateDate(new \DateTime());

            $notification = new Notification();
            $reciever = $currentUser;
            $sender = $application->getStudent()->getUser();
            $message = "Lamentamos comunicarle que la aplicacion a la oportunidad ".$application->getOportunityResearch()->getName()." no ah sido aceptada por el alumno";
            $notification->sendNotification($sender, $reciever, $message);

            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->persist($notification);
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

            $notification = new Notification();
            $mentor = $application->getOportunityResearch()->getMainMentor();
            $reciever = $mentor->getUser();
            $sender = $application->getStudent()->getUser();
            $message = "Felicitaciones, su aplicacion a la oportunidad ".$application->getOportunityResearch()->getName()." ah sido aceptada por el alumno, feliz investigación";
            $notification->sendNotification($sender, $reciever, $message);
            $em = $this->getDoctrine()->getManager();

            //como fue aceptado por ambos, creamos la investigación oficial en el sistema
            $research = new Research();
            //cargamos los datos existentes
            $research->populateFromOportunity($application->getOportunityResearch());
            $research->setStudent($application->getStudent());
            //calculamos la sigla
            $em = $this->getDoctrine()->getManager();
            $classCodeArray = $em->getRepository('BackendBundle:Application')->getClassCode($application->getOportunityResearch(), $application->getStudent());

            $research->setInitialsCode($classCodeArray['initialsCode']);
            $research->setnumbersCode($classCodeArray['numbersCode']);

            $section = $em->getRepository('BackendBundle:Research')->getSection($classCodeArray, $research);

            $research->setSection($section);

            $em = $this->getDoctrine()->getManager();

            $em->persist($application);
            $em->persist($notification);
            $em->persist($research);
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
