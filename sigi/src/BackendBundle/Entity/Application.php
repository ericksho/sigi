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
     * @ORM\OneToOne(targetEntity="Research", mappedBy="application")
     */
    private $research;

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

    public function getStateArray() 
    {
        return array(
            1 => 'Postulado por Alumno', 
            2 => 'Aceptado por Mentor', 
            3 => 'Confirmado por Ambos, en proceso', 
            4 => 'Sigla Enviada a Dara',
            5 => 'Inscripción alumno Enviada a Dara',
            6 => 'Sigla inscrita en Banner',
            7 => 'No seleccionado por Mentor',
            8 => 'No confirmado por Alumno',
            9 => 'Error en la sigla',
            10 => 'Pendiente Revisión Prerequisitos',
            11 => 'No cumple con Prerequisitos'
            );
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
     * Set state
     *
     * @param int $state
     *
     * @return Application
     */
    public function setState($state)
    {
        $this->state = $state;
        $this->lastUpdateDate = new \DateTime();

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
     * Get state by text
     *
     * @param string $text
     *
     * @return int
     */
    public function getStateByText($text)
    {
        return array_search($text, $this->getStateArray());

        switch ($text) {
            case 'Postulado por Alumno':
                return 1;
                break;
            case 'Aceptado por Mentor':
                return 2;
                break;
            case 'Confirmado por Ambos, en proceso':
                return 3;
                break;
            case 'Sigla Enviada a Dara':
                return 4;
                break;
            case 'Inscripción alumno Enviada a Dara':
                return 5;
                break;
            case 'Sigla inscrita en Banner':
                return 6;
                break;
            case 'No seleccionado por Mentor':
                return 7;
                break;
            case 'No confirmado por Alumno':
                return 8;
                break;
            case 'Error en la sigla':
                return 9;
                break;  
            case 'Pendiente Revisión Prerequisitos':
                return 10;
                break;    
            case 'No cumple con Prerequisitos':
                return 11;
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
        return $this->getStateArray()[$state];

        switch ($state) {
            case 1:
                return 'Postulado por Alumno';
                break;
            case 2:
                return 'Aceptado por Mentor';
                break;
            case 3:
                return 'Confirmado por Ambos, en proceso';
                break;
            case 4:
                return 'Sigla Enviada a Dara';
                break;
            case 5:
                return 'Inscripción alumno Enviada a Dara';
                break;
            case 6:
                return 'Sigla inscrita en Banner';
                break;
            case 7:
                return 'No seleccionado por Mentor';
                break;
            case 8:
                return 'No confirmado por Alumno';
                break;
            case 9:
                return 'Error en la sigla';
                break;
            case 10:
                return 'Pendiente Revisión Prerequisitos';
                break;
            case 11:
                return 'No cumple con Prerequisitos';
                break;
            
            default:
                return 0;
                break;
        }
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getStateText()
    {
        return $this->getTextByState($this->state);
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

    /**
     * Set research
     *
     * @param \BackendBundle\Entity\Research $research
     *
     * @return Application
     */
    public function setResearch(\BackendBundle\Entity\Research $research = null)
    {
        $this->research = $research;

        return $this;
    }

    /**
     * Get research
     *
     * @return \BackendBundle\Entity\Research
     */
    public function getResearch()
    {
        return $this->research;
    }
}
