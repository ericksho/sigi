<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\OneToOne(targetEntity="Research", inversedBy="research")
     * @ORM\JoinColumn(name="research_id", referencedColumnName="id")
     */
    private $research;

    /**
     * @ORM\OneToMany(targetEntity="Application", mappedBy="oportunityResearch")
     */
    private $applications;

    /**
     * @ORM\OneToMany(targetEntity="Keyword", mappedBy="oportunityResearch")
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
}

