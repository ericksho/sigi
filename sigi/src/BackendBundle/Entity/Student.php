<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Student
 *
 * @ORM\Table(name="Student")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\StudentRepository")
 */
class Student
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
    * @ORM\OneToOne(targetEntity="User", inversedBy="student")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;

    /**
     * @var bool
     *
     * @ORM\Column(name="uc", type="boolean")
     */
    private $uc;

    /**
     * @ORM\OneToMany(targetEntity="Application", mappedBy="student")
     */
    private $applications;

    /**
     * @ORM\ManyToOne(targetEntity="Department", inversedBy="students")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id")
     */
    private $department;

    /**
     * @ORM\OneToMany(targetEntity="Research", mappedBy="student")
     */
    private $researches;

    public function __construct() {
        $this->researches = new ArrayCollection();
        $this->applications = new ArrayCollection();
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
     * Set uc
     *
     * @param boolean $uc
     *
     * @return Student
     */
    public function setUc($uc)
    {
        $this->uc = $uc;

        return $this;
    }

    /**
     * Get uc
     *
     * @return bool
     */
    public function getUc()
    {
        return $this->uc;
    }

    /**
     * Set StudentNumber
     *
     * @param integer $StudentNumber
     *
     * @return Student
     */
    public function setStudentNumber($studentNumber)
    {
        $this->studentNumber = $studentNumber;

        return $this;
    }

    /**
     * Get StudentNumber
     *
     * @return int
     */
    public function getStudentNumber()
    {
        return $this->studentNumber;
    }

    /**
     * Set user
     *
     * @param \BackendBundle\Entity\User $user
     *
     * @return Student
     */
    public function setUser(\BackendBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \BackendBundle\Entity\User $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set application
     *
     * @param \BackendBundle\Entity\Application $Application
     *
     * @return Student
     */
    public function setApplication(\BackendBundle\Entity\Application $application)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * Get student name
     *
     * @return string
     */
    public function getStudentName()
    {
        return $this->getNameText();
    }

    /**
     * Get student name
     *
     * @return string
     */
    public function getNameText()
    {
        if (is_null($this->user))
        {
            return "Ocurrio un error al cargar el nombre";
        }
        else {
            return $this->user->getShowName();
        }
    }

    /**
     * Get student getFullName
     *
     * @return string
     */
    public function getFullName()
    {
        if (is_null($this->user))
        {
            return "Ocurrio un error al cargar el nombre";
        }
        else {
            return $this->user->getFullName();
        }
    }

    /**
     * Get student Rut
     *
     * @return string
     */
    public function getRut()
    {
        if (is_null($this->user))
        {
            return "0";
        }
        else {
            return $this->user->getRut();
        }
    }

    /**
     * Get student Rut
     *
     * @return string
     */
    public function getRutText()
    {
        if (is_null($this->user))
        {
            return "0";
        }
        else {
            return $this->user->getRutText();
        }
    }

    /**
     * Add application
     *
     * @param \BackendBundle\Entity\Application $application
     *
     * @return Student
     */
    public function addApplication(\BackendBundle\Entity\Application $application)
    {
        $this->applications[] = $application;

        return $this;
    }

    /**
     * Remove application
     *
     * @param \BackendBundle\Entity\Application $application
     */
    public function removeApplication(\BackendBundle\Entity\Application $application)
    {
        $this->applications->removeElement($application);
    }

    /**
     * Get applications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
     * Set department
     *
     * @param \BackendBundle\Entity\Department $department
     *
     * @return Student
     */
    public function setDepartment(\BackendBundle\Entity\Department $department = null)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return \BackendBundle\Entity\Department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Add research
     *
     * @param \BackendBundle\Entity\Research $research
     *
     * @return Student
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
}
