<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * student
 *
 * @ORM\Table(name="student")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\studentRepository")
 */
class student
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
     * @var bool
     *
     * @ORM\Column(name="uc", type="boolean")
     */
    private $uc;

    /**
     * @var int
     *
     * @ORM\Column(name="student_number", type="integer", unique=true)
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
     * @return student
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
     * Set studentNumber
     *
     * @param integer $studentNumber
     *
     * @return student
     */
    public function setStudentNumber($studentNumber)
    {
        $this->studentNumber = $studentNumber;

        return $this;
    }

    /**
     * Get studentNumber
     *
     * @return int
     */
    public function getStudentNumber()
    {
        return $this->studentNumber;
    }

    /**
     * Set specialty
     *
     * @param string $specialty
     *
     * @return student
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
     * @return student
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

