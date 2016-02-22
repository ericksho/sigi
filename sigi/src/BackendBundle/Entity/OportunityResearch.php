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
     * @var bool
     *
     * @ORM\Column(name="publish", type="boolean")
     */
    private $publish;

    /**
     * @ORM\OneToOne(targetEntity="Research", inversedBy="oportunityResearch")
     * @ORM\JoinColumn(name="oportunityResearch_id", referencedColumnName="id")
     */
    private $research;

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
     * @ORM\OneToMany(targetEntity="Requirement", mappedBy="oportunityResearch")
     */
    private $requirements;

    public function __construct() {
        $this->oportunityKeywords = new ArrayCollection();
        $this->applications = new ArrayCollection();
        $this->requirements = new ArrayCollection();
    }

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
}

