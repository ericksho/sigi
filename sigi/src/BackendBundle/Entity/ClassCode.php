<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClassCode
 *
 * @ORM\Table(name="class_code")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\ClassCodeRepository")
 */
class ClassCode
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
     * @ORM\Column(name="initialsCode", type="string", length=4)
     */
    private $initialsCode;

    /**
     * @var int
     *
     * @ORM\Column(name="numbersCode", type="integer")
     */
    private $numbersCode;

    /**
     * @var int
     *
     * @ORM\Column(name="credits", type="integer")
     */
    private $credits;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="mentorIng", type="boolean")
     */
    private $mentorIng;

    /**
     * @var bool
     *
     * @ORM\Column(name="studentIng", type="boolean")
     */
    private $studentIng;

    /**
     * @var bool
     *
     * @ORM\Column(name="cmd", type="boolean")
     */
    private $cmd;

    /**
     * @var int
     *
     * @ORM\Column(name="time", type="integer")
     */
    private $time;

    /**
     * @var bool
     *
     * @ORM\Column(name="graded", type="boolean")
     */
    private $graded;


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
     * Set initialsCode
     *
     * @param string $initialsCode
     *
     * @return ClassCode
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

    /**
     * Set numbersCode
     *
     * @param integer $numbersCode
     *
     * @return ClassCode
     */
    public function setNumbersCode($numbersCode)
    {
        $this->numbersCode = $numbersCode;

        return $this;
    }

    /**
     * Get numbersCode
     *
     * @return int
     */
    public function getNumbersCode()
    {
        return $this->numbersCode;
    }

    /**
     * Set credits
     *
     * @param integer $credits
     *
     * @return ClassCode
     */
    public function setCredits($credits)
    {
        $this->credits = $credits;

        return $this;
    }

    /**
     * Get credits
     *
     * @return int
     */
    public function getCredits()
    {
        return $this->credits;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ClassCode
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
     * Set mentorUcƒ
     *
     * @param boolean $mentorIng
     *
     * @return ClassCode
     */
    public function setMentorIng($mentorIng)
    {
        $this->mentorIng = $mentorIng;

        return $this;
    }

    /**
     * Get mentorIng
     *
     * @return bool
     */
    public function getMentorIng()
    {
        return $this->mentorIng;
    }

    /**
     * Set studentIng
     *
     * @param boolean $studentIng
     *
     * @return ClassCode
     */
    public function setStudentIng($studentIng)
    {
        $this->studentIng = $studentIng;

        return $this;
    }

    /**
     * Get studentIng
     *
     * @return bool
     */
    public function getStudentIng()
    {
        return $this->studentIng;
    }

    /**
     * Set cmd
     *
     * @param boolean $cmd
     *
     * @return ClassCode
     */
    public function setCmd($cmd)
    {
        $this->cmd = $cmd;

        return $this;
    }

    /**
     * Get cmd
     *
     * @return bool
     */
    public function getCmd()
    {
        return $this->cmd;
    }

    /**
     * Set time
     *
     * @param integer $time
     *
     * @return ClassCode
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set graded
     *
     * @param boolean $graded
     *
     * @return ClassCode
     */
    public function setGraded($graded)
    {
        $this->graded = $graded;

        return $this;
    }

    /**
     * Get graded
     *
     * @return bool
     */
    public function getGraded()
    {
        return $this->graded;
    }
}
