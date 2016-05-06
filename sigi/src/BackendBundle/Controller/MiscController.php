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
     * Shows mentor pendings.
     *
     * @Route("/misc/mpendings", name="mentor_pendings")
     * @Method("GET")
     */
    public function mentorPendingAction()
    {
        $em = $this->getDoctrine()->getManager();

        $applications = $em->getRepository('BackendBundle:Application')->findUnattended(1);

        return $this->render('misc/mentorPending.html.twig', array(
            'applications' => $applications,
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

        $oportunityResearches = $em->getRepository('BackendBundle:OportunityResearch')->findPublished();

        return $this->render('misc/studentPending.html.twig', array(
            'oportunityResearches' => $oportunityResearches,
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
