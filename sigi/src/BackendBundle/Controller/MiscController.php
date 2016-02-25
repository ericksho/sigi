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
     * @Route("/misc/listOportunities")
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
     * Lists all public OportunityResearch entities.
     *
     * @Route("/misc/publicOportunities")
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
