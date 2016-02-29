<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Application
 *
 * @ORM\Table(name="application")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\ApplicationRepository")
 */
class Application
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
     * @var int
     *
     * @ORM\Column(name="state", type="integer")
     */
    private $state;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="application_date", type="date")
     */
    private $applicationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_update_date", type="datetime")
     */
    private $lastUpdateDate;

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="applications")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     */
    private $student;

    /**
     * @ORM\ManyToOne(targetEntity="OportunityResearch", inversedBy="applications")
     * @ORM\JoinColumn(name="oportunityResearch_id", referencedColumnName="id")
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
     * Set state
     *
     * @param int $state
     *
     * @return Application
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getStateText()
    {
        return getTextByState($this->state);
    }

    /**
     * Get state by text
     *
     * @param string $text
     *
     * @return int
     */
    public function getStateByText($text)
    {
        switch ($text) {
            case 'Aplicado':
                return 1;
                break;
            case 'Aceptado por Mentor':
                return 2;
                break;
            case 'Aceptado por Ambos':
                return 3;
                break;
            case 'Investigación Oficial en Dara':
                return 4;
                break;
            case 'No seleccionado por Mentor':
                return 5;
                break;
            case 'No aceptado por Alumno':
                return 6;
                break;
            
            default:
                return 0;
                break;
        }
    }

    /**
     * Get text by text
     *
     * @param int $state
     *
     * @return string
     */
    public function getTextByState($state)
    {
        switch ($state) {
            case 1:
                return 'Aplicado';
                break;
            case 2:
                return 'Aceptado por Mentor';
                break;
            case 3:
                return 'Aceptado por Ambos';
                break;
            case 4:
                return 'Investigación Oficial en Dara';
                break;
            case 5:
                return 'No seleccionado por Mentor';
                break;
            case 6:
                return 'No aceptado por Alumno';
                break;
            
            default:
                return 0;
                break;
        }
    }

    /**
     * Set applicationDate
     *
     * @param \DateTime $applicationDate
     *
     * @return Application
     */
    public function setApplicationDate($applicationDate)
    {
        $this->applicationDate = $applicationDate;

        return $this;
    }

    /**
     * Get applicationDate
     *
     * @return \DateTime
     */
    public function getApplicationDate()
    {
        return $this->applicationDate;
    }

    /**
     * Set lastUpdateDate
     *
     * @param \DateTime $lastUpdateDate
     *
     * @return Application
     */
    public function setLastUpdateDate($lastUpdateDate)
    {
        $this->lastUpdateDate = $lastUpdateDate;

        return $this;
    }

    /**
     * Get lastUpdateDate
     *
     * @return \DateTime
     */
    public function getLastUpdateDate()
    {
        return $this->lastUpdateDate;
    }

    /**
     * Set student
     *
     * @param \BackendBundle\Entity\Student $student
     *
     * @return User
     */
    public function setStudent(\BackendBundle\Entity\Student $student)
    {
        $this->student = $student;
        $student->setApplication($this);

        return $this;
    }

    /**
     * Get student
     *
     * @return \BackendBundle\Entity\Student
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set oportunityResearch
     *
     * @param \BackendBundle\Entity\OportunityResearch $oportunityResearch
     *
     * @return OportunityResearch
     */
    public function setOportunityResearch(\BackendBundle\Entity\OportunityResearch $oportunityResearch)
    {
        $this->oportunityResearch = $oportunityResearch;
        $oportunityResearch->setApplication($this);

        return $this;
    }

    /**
     * Get oportunityResearch
     *
     * @return \BackendBundle\Entity\OportunityResearch
     */
    public function getOportunityResearch()
    {
        return $this->oportunityResearch;
    }
}

