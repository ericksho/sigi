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
     * @ORM\Column(name="code", type="string", length=10)
     */
    private $code;

    /**
     * @var int
     *
     * @ORM\Column(name="section", type="integer")
     */
    private $section;

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
    private $oportunityKeywordsOP;

    /**
     * @ORM\ManyToMany(targetEntity="Prerequisite", inversedBy="oportunityResearch")
     * @ORM\JoinTable(name="prerequisites_researches")
     */
    private $prerequisitesOP;

    public function __construct() {
        $this->prerequisitesOP = new ArrayCollection();
        $this->oportunityKeywordsOP = new ArrayCollection();
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
     * @return OportunityResearch
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
     * @return OportunityResearch
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
     * @return OportunityResearch
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
     * Set modalityOP
     *
     * @param integer $modalityOP
     *
     * @return OportunityResearch
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
     * Get oportunityKeywordsOP
     *
     * @return \BackendBundle\Entity\Keyword
     */
    public function getOportunityKeywordsOP()
    {
        return $this->oportunityKeywordsOP;
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
    public function getKeywordsArrayOP()
    {
        $keywords = $this->oportunityKeywordsOP->getValues();

        return $keywords;
    }

    /**
     * Add keywordOP
     *
     * @param \BackendBundle\Entity\Keyword $keywordOP
     *
     * @return OportunityResearch
     */
    public function addOportunityKeywordOP(\BackendBundle\Entity\Keyword $keywordOP)
    {
        $this->oportunityKeywordsOP->add($keywordOP);
        return $this;
    }

    /**
     * Delete keywordOP
     *
     * @param \BackendBundle\Entity\Keyword $keywordOP
     *
     * @return OportunityResearch
     */
    public function removeOportunityKeywordOP(\BackendBundle\Entity\Keyword $keywordOP)
    {
        $this->oportunityKeywordsOP->removeElement($keywordOP);
        return $this;
    }

    /**
     * Add keywordOP
     *
     * @param \BackendBundle\Entity\Keyword $keywordOP
     *
     * @return OportunityResearch
     */
    public function setOportunityKeywordOP(ArrayCollection $keywordsOP)
    {
        $this->oportunityKeywordsOP = $keywordsOP;
        return $this;
    }


    /**
     * Get PrerequisiteOP
     *
     * @return array
     */
    public function getPrerequisitesOPArray()
    {
        $prerequisites = $this->prerequisitesOP->getValues();

        return $prerequisites;
    }

    /**
     * Add prerequisiteOP
     *
     * @param \BackendBundle\Entity\Prerequisite $prerequisiteOP
     *
     * @return OportunityResearch
     */
    public function addPrerequisiteOP(\BackendBundle\Entity\Prerequisite $prerequisiteOP)
    {
        $this->prerequisitesOP->add($prerequisiteOP);
        return $this;
    }

    /**
     * Delete prerequisiteOP
     *
     * @param \BackendBundle\Entity\Prerequisite $prerequisiteOP
     *
     * @return OportunityResearch
     */
    public function removePrerequisiteOP(\BackendBundle\Entity\Prerequisite $prerequisiteOP)
    {
        $this->prerequisitesOP->removeElement($prerequisiteOP);
        return $this;
    }

    /**
     * Add prerequisiteOP
     *
     * @param \BackendBundle\Entity\Prerequisite $prerequisiteOP
     *
     * @return OportunityResearch
     */
    public function setPrerequisiteOP(ArrayCollection $prerequisiteOP)
    {
        $this->prerequisitesOP = $prerequisiteOP;
        return $this;
    }

    /**
     * Get prerequisitesOP
     *
     * @return \BackendBundle\Entity\Prerequisite
     */
    public function getPrerequisitesOP()
    {
        return $this->prerequisitesOP;
    }
}

