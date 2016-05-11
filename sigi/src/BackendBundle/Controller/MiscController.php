<?php

namespace BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BackendBundle\Entity\OportunityResearch;
use BackendBundle\Form\OportunityResearchType;

class MiscController extends Controller
{
    /**
     * Lists all OportunityResearch entities.
     *
     * @Route("/misc/listOportunities", name="listOportunities")
     * @Method("GET")
     */
    public function listOportunitiesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $oportunityResearches = $em->getRepository('BackendBundle:OportunityResearch')->findPublished();

        return $this->render('misc/listOportunities.html.twig', array(
            'oportunityResearches' => $oportunityResearches,
        ));
    }

    /**
     * Controls pending entries (login)
     *
     * @Route("/misc/router", name="login_router")
     * @Method("GET")
     */
    public function routerAction()
    {
        $em = $this->getDoctrine()->getManager();

        if(!$this->get('security.context')->isGranted('ROLE_ADMIN'))
        {
            if($this->get('security.context')->isGranted('ROLE_MENTOR'))
                return $this->mentorPendingAction();

            if($this->get('security.context')->isGranted('ROLE_STUDENT'))
                return $this->studentPendingAction();
        }
        
        return $this->listOportunitiesAction();
    }
    
    /**
     * Shows mentor pendings.
     *
     * @Route("/misc/mpendings", name="mentor_pendings")
     * @Method("GET")
     */
    public function mentorPendingAction()
    {
        $em = $this->getDoctrine()->getManager();
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        $applications = $em->getRepository('BackendBundle:Application')->findUnattendedFromMentor($currentUser->getMentor());
        $oportunityResearches = $em->getRepository('BackendBundle:OportunityResearch')->findUnattendedFromMentor($currentUser->getMentor());

        return $this->render('misc/mentorPending.html.twig', array(
            'applications' => $applications,
            'oportunityResearches' => $oportunityResearches,
        ));
    }

    /**
     * Shows student pendings.
     *
     * @Route("/misc/spendings", name="student_pendings")
     * @Method("GET")
     */
    public function studentPendingAction()
    {
        $em = $this->getDoctrine()->getManager();

        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        $applications = $em->getRepository('BackendBundle:Application')->findUnattendedFromStudent($currentUser->getStudent());

        return $this->render('misc/studentPending.html.twig', array(
            'applications' => $applications,
        ));
    }

    /**
     * Lists all public OportunityResearch entities.
     *
     * @Route("/misc/publicOportunities", name="publicOportunities")
     * @Method("GET")
     */
    public function publicOportunities()
    {
        $em = $this->getDoctrine()->getManager();

        $oportunityResearches = $em->getRepository('BackendBundle:OportunityResearch')->findPublic();

        return $this->render('misc/publicOportunities.html.twig', array(
            'oportunityResearches' => $oportunityResearches,
        ));
    }

}
