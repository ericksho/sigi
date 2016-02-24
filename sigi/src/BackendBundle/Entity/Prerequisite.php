<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prerequisite
 *
 * @ORM\Table(name="prerequisite")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\PrerequisiteRepository")
 */
class Prerequisite
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="courseNumber", type="string", length=10, unique=true)
     */
    private $courseNumber;

    /**
     * @ORM\ManyToMany(targetEntity="OportunityResearch", mappedBy="prerequisites")
     */
    private $oportunityResearch;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set courseNumber
     *
     * @param string $courseNumber
     *
     * @return Prerequisite
     */
    public function setCourseNumber($courseNumber)
    {
        $this->courseNumber = $courseNumber;

        return $this;
    }

    /**
     * Get courseNumber
     *
     * @return string
     */
    public function getCourseNumber()
    {
        return $this->courseNumber;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->oportunityResearch = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add oportunityResearch
     *
     * @param \BackendBundle\Entity\OportunityResearch $oportunityResearch
     *
     * @return Prerequisite
     */
    public function addOportunityResearch(\BackendBundle\Entity\OportunityResearch $oportunityResearch)
    {
        $this->oportunityResearch[] = $oportunityResearch;

        return $this;
    }

    /**
     * Remove oportunityResearch
     *
     * @param \BackendBundle\Entity\OportunityResearch $oportunityResearch
     */
    public function removeOportunityResearch(\BackendBundle\Entity\OportunityResearch $oportunityResearch)
    {
        $this->oportunityResearch->removeElement($oportunityResearch);
    }

    /**
     * Get oportunityResearch
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOportunityResearch()
    {
        return $this->oportunityResearch;
    }
}
