<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Department
 *
 * @ORM\Table(name="department")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\DepartmentRepository")
 */
class Department
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
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Faculty", inversedBy="departments")
     * @ORM\JoinColumn(name="faculty_id", referencedColumnName="id")
     */
    private $faculty;

    /**
     * @ORM\OneToMany(targetEntity="Mentor", mappedBy="department")
     */
    private $mentors;

    /**
     * @ORM\OneToMany(targetEntity="Research", mappedBy="department")
     */
    private $researches;

    /**
     * @var string
     *
     * @ORM\Column(name="initials_code", type="string", length=4)
     */
    private $initialsCode;

    /**
     * @ORM\OneToMany(targetEntity="OportunityResearch", mappedBy="department")
     */
    private $oportunities;

    /**
     * @ORM\OneToMany(targetEntity="Student", mappedBy="department")
     */
    private $students;

    public function __construct() {
        $this->mentors = new ArrayCollection();
        $this->researches = new ArrayCollection();
        $this->oportunities = new ArrayCollection();
        $this->students = new ArrayCollection();
    }


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
     * Set name
     *
     * @param string $name
     *
     * @return Department
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get faculty
     *
     * @return string
     */
    public function getFaculty()
    {
        return $this->faculty;
    }

    /**
     * Set faculty
     *
     * @param \BackendBundle\Entity\Faculty $faculty
     *
     * @return Department
     */
    public function setFaculty(\BackendBundle\Entity\Faculty $faculty)
    {
        $this->faculty = $faculty;

        return $this;
    }

    /**
     * Add mentor
     *
     * @param \BackendBundle\Entity\Mentor $mentor
     *
     * @return Department
     */
    public function addMentor(\BackendBundle\Entity\Mentor $mentor)
    {
        $this->mentors[] = $mentor;

        return $this;
    }

    /**
     * Remove mentor
     *
     * @param \BackendBundle\Entity\Mentor $mentor
     */
    public function removeMentor(\BackendBundle\Entity\Mentor $mentor)
    {
        $this->mentors->removeElement($mentor);
    }

    /**
     * Get mentors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMentors()
    {
        return $this->mentors;
    }

    /**
     * Add research
     *
     * @param \BackendBundle\Entity\Research $research
     *
     * @return Department
     */
    public function addResearch(\BackendBundle\Entity\Research $research)
    {
        $this->researches[] = $research;

        return $this;
    }

    /**
     * Remove research
     *
     * @param \BackendBundle\Entity\Research $research
     */
    public function removeResearch(\BackendBundle\Entity\Research $research)
    {
        $this->researches->removeElement($research);
    }

    /**
     * Get researches
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResearches()
    {
        return $this->researches;
    }

    /**
     * Add oportunity
     *
     * @param \BackendBundle\Entity\OportunityResearch $oportunity
     *
     * @return Department
     */
    public function addOportunity(\BackendBundle\Entity\OportunityResearch $oportunity)
    {
        $this->oportunities[] = $oportunity;

        return $this;
    }

    /**
     * Remove oportunity
     *
     * @param \BackendBundle\Entity\OportunityResearch $oportunity
     */
    public function removeOportunity(\BackendBundle\Entity\OportunityResearch $oportunity)
    {
        $this->oportunities->removeElement($oportunity);
    }

    /**
     * Get oportunities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOportunities()
    {
        return $this->oportunities;
    }

    /**
     * Set initialsCode
     *
     * @param string $initialsCode
     *
     * @return Department
     */
    public function setInitialsCode($initialsCode)
    {
        $this->initialsCode = $initialsCode;

        return $this;
    }

    /**
     * Get initialsCode
     *
     * @return string
     */
    public function getInitialsCode()
    {
        return $this->initialsCode;
    }
}
