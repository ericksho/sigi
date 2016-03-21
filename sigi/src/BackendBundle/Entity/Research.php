<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Research
 *
 * @ORM\Table(name="research")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\ResearchRepository")
 */
class Research
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
     * @ORM\Column(name="initials_code", type="string", length=4)
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
     * @ORM\Column(name="section", type="integer")
     */
    private $section;

    /**
     * @ORM\ManyToOne(targetEntity="Department", inversedBy="researches")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id")
     */
    private $department;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="date")
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="Mentor", inversedBy="researchAsMain")
     * @ORM\JoinColumn(name="mainMentor_id", referencedColumnName="id")
     */
    private $mainMentor;

    /**
     * @ORM\ManyToOne(targetEntity="Mentor", inversedBy="researchAsSecondary")
     * @ORM\JoinColumn(name="secondaryMentor_id", referencedColumnName="id")
     */
    private $secondaryMentor;

    /**
     * @ORM\ManyToOne(targetEntity="Mentor", inversedBy="researchAsThertiary")
     * @ORM\JoinColumn(name="thertiaryMentor_id", referencedColumnName="id")
     */
    private $thertiaryMentor;

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="researches")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     */
    private $student;

    /**
     * @ORM\ManyToOne(targetEntity="OportunityResearch", inversedBy="researches")
     * @ORM\JoinColumn(name="oportunityResearch_id", referencedColumnName="id")
     */
    private $oportunityResearch;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date_op", type="datetime")
     */
    private $creationDateOP;

    /**
     * @var string
     *
     * @ORM\Column(name="name_op", type="string", length=125, unique=true)
     */
    private $nameOP;

    /**
     * @var bool
     *
     * @ORM\Column(name="cmd", type="boolean")
     */
    private $cmd;

    /**
     * @var int
     *
     * @ORM\Column(name="credits", type="integer")
     */
    private $credits;

    /**
     * @var int
     *
     * @ORM\Column(name="responsible_mentor", type="integer")
     */
    private $responsibleMentor;

    /**
     * @var string
     *
     * @ORM\Column(name="description_op", type="text")
     */
    private $descriptionOP;

    /**
     * @var int
     *
     * @ORM\Column(name="modality_op", type="integer")
     */
    private $modalityOP;

    /**
     * @ORM\ManyToMany(targetEntity="Keyword", inversedBy="oportunityResearch")
     * @ORM\JoinTable(name="keywords_researches")
     */
    private $oportunityKeywords;

    /**
     * @ORM\ManyToMany(targetEntity="Prerequisite", inversedBy="oportunityResearch")
     * @ORM\JoinTable(name="prerequisites_researches")
     */
    private $prerequisites;

    public function __construct() {
        $this->prerequisites = new ArrayCollection();
        $this->oportunityKeywords = new ArrayCollection();
    }

    /**
     * Set initialsCode
     *
     * @param string $initialsCode
     *
     * @return Research
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
     * @return Research
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Research
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set section
     *
     * @param integer $section
     *
     * @return Research
     */
    public function setSection($section)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return int
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Research
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set oportunityResearch
     *
     * @param \BackendBundle\Entity\OportunityResearch $oportunityResearch
     *
     * @return Research
     */
    public function setOportunityResearch($oportunityResearch)
    {
        $this->oportunityResearch = $oportunityResearch;

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
     * Set creationDateOP
     *
     * @param \DateTime $creationDateOP
     *
     * @return Research
     */
    public function setCreationDateOP($creationDateOP)
    {
        $this->creationDateOP = $creationDateOP;

        return $this;
    }

    /**
     * Get creationDateOP
     *
     * @return \DateTime
     */
    public function getCreationDateOP()
    {
        return $this->creationDateOP;
    }

    /**
     * Set nameOP
     *
     * @param string $nameOP
     *
     * @return Research
     */
    public function setName($nameOP)
    {
        $this->nameOP = $nameOP;

        return $this;
    }

    /**
     * Get nameOP
     *
     * @return string
     */
    public function getNameOP()
    {
        return $this->nameOP;
    }

    /**
     * Set descriptionOP
     *
     * @param string $descriptionOP
     *
     * @return Research
     */
    public function setDescriptionOP($descriptionOP)
    {
        $this->descriptionOP = $descriptionOP;

        return $this;
    }

    /**
     * Get descriptionOP
     *
     * @return string
     */
    public function getDescriptionOP()
    {
        return $this->descriptionOP;
    }

    /**
     * Set cmd
     *
     * @param boolean $cmd
     *
     * @return Research
     */
    public function setCmd($cmd)
    {
        $this->cmd = $cmd;

        return $this;
    }

    /**
     * Get cmd
     *
     * @return boolean
     */
    public function getCmd()
    {
        return $this->cmd;
    }

    /**
     * Set modalityOP
     *
     * @param integer $modalityOP
     *
     * @return Research
     */
    public function setModalityOP($modalityOP)
    {
        $this->modalityOP = $modalityOP;

        return $this;
    }

    /**
     * Get modalityOP
     *
     * @return int
     */
    public function getModalityOP()
    {
        return $this->modalityOP;
    }

    /**
     * Set mainMentor
     *
     * @param \BackendBundle\Entity\ $mainMentor
     *
     * @return Notification
     */
    public function setMainMentor(\BackendBundle\Entity\Mentor $mainMentor = null)
    {
        if (is_int($mainMentor))
            if(is_null($this->mainMentor))
                $mainMentor->deleteOportunityResearchAsMain($this);
        else
            $mainMentor->addOportunityResearchAsMain($this);

        $this->mainMentor = $mainMentor;

        return $this;
    }

    /**
     * Set student
     *
     * @param \BackendBundle\Entity\Student $student
     *
     * @return Notification
     */
    public function setStudent(\BackendBundle\Entity\Student $student)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get mainMentor
     *
     * @return \BackendBundle\Entity\Mentor
     */
    public function getMainMentor()
    {
        return $this->mainMentor;
    }

    /**
     * Set secondaryMentor
     *
     * @param \BackendBundle\Entity\ $secondaryMentor
     *
     * @return Notification
     */
    public function setSecondaryMentor(\BackendBundle\Entity\Mentor $secondaryMentor = null)
    {
        if (is_int($secondaryMentor))
            if(is_null($this->secondaryMentor))
                $secondaryMentor->deleteOportunityResearchAsSecondary($this);
        else
            $secondaryMentor->addOportunityResearchAsSecondary($this);

        $this->secondaryMentor = $secondaryMentor;

        return $this;
    }

    /**
     * Get secondaryMentor
     *
     * @return \BackendBundle\Entity\Mentor
     */
    public function getSecondaryMentor()
    {
        return $this->secondaryMentor;
    }

    /**
     * Set thertiaryMentor
     *
     * @param \BackendBundle\Entity\ $thertiaryMentor
     *
     * @return Notification
     */
    public function setThertiaryMentor(\BackendBundle\Entity\Mentor $thertiaryMentor = null)
    {
        if (is_int($thertiaryMentor))
            if(is_null($this->thertiaryMentor))
                $thertiaryMentor->deleteOportunityResearchAsThertiary($this);
        else
            $thertiaryMentor->addOportunityResearchAsThertiary($this);

        $this->thertiaryMentor = $thertiaryMentor;

        return $this;
    }

    /**
     * Get thertiaryMentor
     *
     * @return \BackendBundle\Entity\Mentor
     */
    public function getThertiaryMentor()
    {
        return $this->thertiaryMentor;
    }

    /**
     * Get oportunityKeywords
     *
     * @return \BackendBundle\Entity\Keyword
     */
    public function getOportunityKeywords()
    {
        return $this->oportunityKeywords;
    }

    /**
     * Get mentorsName
     *
     * @return array
     */
    public function getMentorsName()
    {
        $mentors = array();
        $count = 0;
        $main = $this->mainMentor;
        $secondary = $this->secondaryMentor;
        $thertiary = $this->thertiaryMentor;

        if (!is_null($main))
        {
            $mentors[$count] = $main->getShowName();
            $count = $count + 1;
        }
        if(!is_null($secondary))
        {
            $mentors[$count] = $secondary->getShowName();
            $count = $count + 1;
        }
        if(!is_null($thertiary))
            $mentors[$count] = $thertiary->getShowName();

        return $mentors;
    }

    /**
     * Get keywordsOP
     *
     * @return array
     */
    public function getKeywordsArray()
    {
        $keywords = $this->oportunityKeywords->getValues();

        return $keywords;
    }

    /**
     * Add keywordOP
     *
     * @param \BackendBundle\Entity\Keyword $keywordOP
     *
     * @return Research
     */
    public function addOportunityKeyword(\BackendBundle\Entity\Keyword $keywordOP)
    {
        $this->oportunityKeywords->add($keywordOP);
        return $this;
    }

    /**
     * Delete keywordOP
     *
     * @param \BackendBundle\Entity\Keyword $keywordOP
     *
     * @return Research
     */
    public function removeOportunityKeyword(\BackendBundle\Entity\Keyword $keywordOP)
    {
        $this->oportunityKeywords->removeElement($keywordOP);
        return $this;
    }

    /**
     * Add keywordOP
     *
     * @param \Doctrine\ORM\PersistentCollection $keywordOP
     *
     * @return Research
     */
    public function setOportunityKeyword(\Doctrine\ORM\PersistentCollection $keywordsOP)
    {
        $this->oportunityKeywords = $keywordsOP;
        return $this;
    }


    /**
     * Get PrerequisiteOP
     *
     * @return array
     */
    public function getPrerequisitesArray()
    {
        $prerequisites = $this->prerequisites->getValues();

        return $prerequisites;
    }

    /**
     * Add prerequisiteOP
     *
     * @param \BackendBundle\Entity\Prerequisite $prerequisiteOP
     *
     * @return Research
     */
    public function addPrerequisiteOP(\BackendBundle\Entity\Prerequisite $prerequisiteOP)
    {
        $this->prerequisites->add($prerequisiteOP);
        return $this;
    }

    /**
     * Delete prerequisiteOP
     *
     * @param \BackendBundle\Entity\Prerequisite $prerequisiteOP
     *
     * @return Research
     */
    public function removePrerequisiteOP(\BackendBundle\Entity\Prerequisite $prerequisiteOP)
    {
        $this->prerequisites->removeElement($prerequisiteOP);
        return $this;
    }

    /**
     * Add prerequisiteOP
     *
     * @param \Doctrine\ORM\PersistentCollection $prerequisiteOP
     *
     * @return Research
     */
    public function setPrerequisites(\Doctrine\ORM\PersistentCollection $prerequisiteOP)
    {
        $this->prerequisites = $prerequisiteOP;
        return $this;
    }

    /**
     * Get prerequisites
     *
     * @return \BackendBundle\Entity\Prerequisite
     */
    public function getPrerequisites()
    {
        return $this->prerequisites;
    }

    /**
     * Set credits
     *
     * @param integer $credits
     *
     * @return Research
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
     * Set responsibleMentor
     *
     * @param integer $responsibleMentor
     *
     * @return Research
     */
    public function setResponsibleMentor($responsibleMentor)
    {
        $this->responsibleMentor = $responsibleMentor;

        return $this;
    }

    /**
     * Get responsibleMentor
     *
     * @return int
     */
    public function getResponsibleMentor()
    {
        return $this->responsibleMentor;
    }

    /**
     * Populate from Oportunity
     *
     * @param \BackendBundle\Entity\OportunityResearch
     *
     * @return Research
     */
    public function populateFromOportunity(\BackendBundle\Entity\OportunityResearch $oportunityResearch)
    {
        $this->setOportunityResearch($oportunityResearch);
        $this->setPrerequisites($oportunityResearch->getPrerequisites());
        $this->setOportunityKeywordOP($oportunityResearch->getKeywords());
        $this->setCreationDate(new \DateTime());
        $this->setCreationDateOP($oportunityResearch->getCreationDate());
        $this->setName($oportunityResearch->getName());
        $this->setDescriptionOP($oportunityResearch->getDescription());
        $this->setModalityOP($oportunityResearch->getModality());
        $this->setMainMentor($oportunityResearch->getMainMentor());
        $this->setSecondaryMentor($oportunityResearch->getSecondaryMentor());
        $this->setThertiaryMentor($oportunityResearch->getThertiaryMentor());
        $this->setCmd($oportunityResearch->getCmd());
        $this->setResponsibleMentor($oportunityResearch->getResponsibleMentor());
        return $this;
    }    
}

