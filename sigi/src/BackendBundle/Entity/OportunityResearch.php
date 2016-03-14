<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * OportunityResearch
 *
 * @ORM\Table(name="oportunity_research")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\OportunityResearchRepository")
 */
class OportunityResearch
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
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=125, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="public", type="integer")
     */
    private $public;

    /**
     * @var int
     *
     * @ORM\Column(name="modality", type="integer")
     */
    private $modality;

    /**
     * @var int
     *
     * @ORM\Column(name="vacants", type="integer")
     */
    private $vacants;

    /**
     * @var bool
     *
     * @ORM\Column(name="publish", type="boolean")
     */
    private $publish;

    /**
     * @var bool
     *
     * @ORM\Column(name="cmd", type="boolean")
     */
    private $cmd;

    /**
     * @ORM\OneToMany(targetEntity="Research", mappedBy="oportunityResearch")
     */
    private $researches;

    /**
     * @ORM\OneToMany(targetEntity="Application", mappedBy="oportunityResearch")
     */
    private $applications;

    /**
     * @ORM\ManyToMany(targetEntity="Keyword", inversedBy="oportunityResearch")
     * @ORM\JoinTable(name="keywords_oportunityResearchs")
     */
    private $oportunityKeywords;

    /**
     * @ORM\ManyToMany(targetEntity="Requirement", inversedBy="oportunityResearch")
     * @ORM\JoinTable(name="requirements_oportunityResearchs")
     */
    private $requirements;

    /**
     * @ORM\ManyToMany(targetEntity="Prerequisite", inversedBy="oportunityResearch")
     * @ORM\JoinTable(name="prerequisites_oportunityResearchs")
     */
    private $prerequisites;
    
    /**
     * @ORM\ManyToOne(targetEntity="Department", inversedBy="oportunities")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id")
     */
    private $department;

    /**
     * @ORM\ManyToOne(targetEntity="Mentor", inversedBy="oportunitiesAsMain")
     * @ORM\JoinColumn(name="mainMentor_id", referencedColumnName="id")
     */
    private $mainMentor;

    /**
     * @ORM\ManyToOne(targetEntity="Mentor", inversedBy="oportunitiesAsSecondary")
     * @ORM\JoinColumn(name="secondaryMentor_id", referencedColumnName="id")
     */
    private $secondaryMentor;

    /**
     * @ORM\ManyToOne(targetEntity="Mentor", inversedBy="oportunitiesAsThertiary")
     * @ORM\JoinColumn(name="thertiaryMentor_id", referencedColumnName="id")
     */
    private $thertiaryMentor;

    public function __construct() {
        $this->prerequisites = new ArrayCollection();
        $this->oportunityKeywords = new ArrayCollection();
        $this->applications = new ArrayCollection();
        $this->requirements = new ArrayCollection();
    }

    /**
     * Set department
     *
     * @param \BackendBundle\Entity\Department $department
     *
     * @return OportunityResearch
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return OportunityResearch
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
     * Set name
     *
     * @param string $name
     *
     * @return OportunityResearch
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
     * Set description
     *
     * @param string $description
     *
     * @return OportunityResearch
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set public
     *
     * @param integer $public
     *
     * @return OportunityResearch
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return int
     */
    public function getPublic()
    {
        return $this->public;
    }

    /**
     * Set modality
     *
     * @param integer $modality
     *
     * @return OportunityResearch
     */
    public function setModality($modality)
    {
        $this->modality = $modality;

        return $this;
    }

    /**
     * Get modality
     *
     * @return int
     */
    public function getModality()
    {
        return $this->modality;
    }

    /**
     * Set publish
     *
     * @param boolean $publish
     *
     * @return OportunityResearch
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;

        return $this;
    }

    /**
     * Get publish
     *
     * @return bool
     */
    public function getPublish()
    {
        return $this->publish;
    }

    /**
     * Set cmd
     *
     * @param boolean $cmd
     *
     * @return OportunityResearch
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
     * Is owner
     *
     * @param \BackendBundle\Entity\ $user
     *
     * @return bool
     */
    public function isOwner(\BackendBundle\Entity\User $user)
    {
        $owner = false;
        if(!is_null($this->mainMentor))
        {
            $userMentor =$this->mainMentor->getUser();

            if($userMentor->getId() == $user->getId())
                $owner = true;
        }
        if(!is_null($this->secondaryMentor))
        {
            $userMentor =$this->mainMentor->getUser();

            if($userMentor->getId() == $user->getId())
                $owner = true;
        }
        if(!is_null($this->thertiaryMentor))
        {
            $userMentor =$this->mainMentor->getUser();

            if($userMentor->getId() == $user->getId())
                $owner = true;
        }

        return $owner;
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
     * Is mentor
     *
     * @param \BackendBundle\Entity\Mentor $mentor
     *
     * @return bool
     */
    public function isMentor(\BackendBundle\Entity\Mentor $mentor)
    {
        $isMentor = false;
        $mentorId = $mentor->getId();

        if(!is_null($this->mainMentor))
            if($mentorId == $this->mainMentor->getId())
                $isMentor = true;
        if(!is_null($this->secondaryMentor))
            if($mentorId == $this->secondaryMentor->getId())
                $isMentor = true;
        if(!is_null($this->thertiaryMentor))
            if($mentorId == $this->thertiaryMentor->getId())
                $isMentor = true;

        return $isMentor;
    }

    /**
     * Get keywords
     *
     * @return array
     */
    public function getKeywordsArray()
    {
        $keywords = $this->oportunityKeywords->getValues();

        return $keywords;
    }

    /**
     * Get keywords
     *
     * @return array
     */
    public function getKeywords()
    {
        $keywords = $this->oportunityKeywords;

        return $keywords;
    }

    /**
     * Add keyword
     *
     * @param \BackendBundle\Entity\Keyword $keyword
     *
     * @return OportunityResearch
     */
    public function addOportunityKeyword(\BackendBundle\Entity\Keyword $keyword)
    {
        $this->oportunityKeywords->add($keyword);
        return $this;
    }

    /**
     * Delete keyword
     *
     * @param \BackendBundle\Entity\Keyword $keyword
     *
     * @return OportunityResearch
     */
    public function removeOportunityKeyword(\BackendBundle\Entity\Keyword $keyword)
    {
        $this->oportunityKeywords->removeElement($keyword);
        return $this;
    }

    /**
     * Add keyword
     *
     * @param \BackendBundle\Entity\Keyword $keyword
     *
     * @return OportunityResearch
     */
    public function setOportunityKeyword(ArrayCollection $keywords)
    {
        $this->oportunityKeywords = $keywords;
        return $this;
    }

    /**
     * Set researches
     *
     * @param \BackendBundle\Entity\Research $researches
     *
     * @return OportunityResearch
     */
    public function setResearches(\BackendBundle\Entity\Research $researches = null)
    {
        $this->researches = $researches;

        return $this;
    }

    /**
     * Get researches
     *
     * @return \BackendBundle\Entity\Research
     */
    public function getResearches()
    {
        return $this->researches;
    }

    /**
     * Add application
     *
     * @param \BackendBundle\Entity\Application $application
     *
     * @return OportunityResearch
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
     * Get Prerequisite
     *
     * @return array
     */
    public function getPrerequisitesArray()
    {
        $prerequisites = $this->prerequisites->getValues();

        return $prerequisites;
    }

    /**
     * Add prerequisite
     *
     * @param \BackendBundle\Entity\Prerequisite $prerequisite
     *
     * @return OportunityResearch
     */
    public function addPrerequisite(\BackendBundle\Entity\Prerequisite $prerequisite)
    {
        $this->prerequisites->add($prerequisite);
        return $this;
    }

    /**
     * Delete prerequisite
     *
     * @param \BackendBundle\Entity\Prerequisite $prerequisite
     *
     * @return OportunityResearch
     */
    public function removePrerequisite(\BackendBundle\Entity\Prerequisite $prerequisite)
    {
        $this->prerequisites->removeElement($prerequisite);
        return $this;
    }

    /**
     * Add prerequisite
     *
     * @param \BackendBundle\Entity\Prerequisite $prerequisite
     *
     * @return OportunityResearch
     */
    public function setPrerequisite(ArrayCollection $prerequisite)
    {
        $this->prerequisites = $prerequisite;
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
     * Get Modality text
     *
     * @return string
     */
    public function getModalityText()
    {
        switch ($this->modality) {
            case 1:
                $text = 'Alfa numerico';
                break;
            
            case 2:
                $text = 'Nota 1-7';
                break;
        }

        return $text;
    }

    /**
     * Set application
     *
     * @param \BackendBundle\Entity\Application $Application
     *
     * @return OportunityResearch
     */
    public function setApplication(\BackendBundle\Entity\Application $application)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * Set vacants
     *
     * @param integer $vacants
     *
     * @return OportunityResearch
     */
    public function setVacants($vacants)
    {
        $this->vacants = $vacants;

        return $this;
    }

    /**
     * Get vacants
     *
     * @return int
     */
    public function getVacants()
    {
        return $this->vacants;
    }

    /**
     * Get open vacants
     *
     * @return int
     */
    public function getOpenVacants()
    {
        $usedVacants = 0;
        foreach ($this->applications as $application) {
            if ($application->getState() == 3 || $application->getState() == 4 || $application->getState() == 5 )
            {
                $usedVacants = $usedVacants + 1;
            }
            
        }
        $openVacants = $this->getVacants() - $usedVacants;
        return $openVacants;
    }
}
