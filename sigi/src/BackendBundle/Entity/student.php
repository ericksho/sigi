<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    * @OneToOne(targetEntity="User", inversedBy="student")
    * @JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;

    /**
     * @var bool
     *
     * @ORM\Column(name="uc", type="boolean")
     */
    private $uc;

    /**
     * @var int
     *
     * @ORM\Column(name="Student_number", type="integer", unique=true)
     */
    private $studentNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="specialty", type="string", length=30)
     */
    private $specialty;

    /**
     * @var string
     *
     * @ORM\Column(name="faculty", type="string", length=30)
     */
    private $faculty;

    /**
     * @OneToMany(targetEntity="Application", mappedBy="student")
     */
    private $applications;

    /**
     * @OneToMany(targetEntity="Research", mappedBy="student")
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
        return $this->StudentNumber;
    }

    /**
     * Set specialty
     *
     * @param string $specialty
     *
     * @return Student
     */
    public function setSpecialty($specialty)
    {
        $this->specialty = $specialty;

        return $this;
    }

    /**
     * Get specialty
     *
     * @return string
     */
    public function getSpecialty()
    {
        return $this->specialty;
    }

    /**
     * Set faculty
     *
     * @param string $faculty
     *
     * @return Student
     */
    public function setFaculty($faculty)
    {
        $this->faculty = $faculty;

        return $this;
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
}

