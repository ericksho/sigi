<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Mentor
 *
 * @ORM\Table(name="mentor")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\MentorRepository")
 */
class Mentor
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
    * @ORM\OneToOne(targetEntity="User", inversedBy="mentor")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;

    /**
     * @var bool
     *
     * @ORM\Column(name="uc", type="boolean")
     */
    private $uc;

    /**
     * @ORM\ManyToOne(targetEntity="Department")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id")
     */
    private $department;

    /**
     * @ORM\OneToMany(targetEntity="Keyword", mappedBy="mentor")
     */
    private $mentorKeywords;

    /**
     * @ORM\OneToMany(targetEntity="OportunityResearch", mappedBy="mainMentor")
     */
    private $oportunitiesAsMain;

    /**
     * @ORM\OneToMany(targetEntity="OportunityResearch", mappedBy="secondaryMentor")
     */
    private $oportunitiesAsSecondary;

    /**
     * @ORM\OneToMany(targetEntity="OportunityResearch", mappedBy="thertiaryMentor")
     */
    private $oportunitiesAsThertiary;

    /**
     * @ORM\OneToMany(targetEntity="Research", mappedBy="mainMentor")
     */
    private $researchAsMain;

    /**
     * @ORM\OneToMany(targetEntity="Research", mappedBy="secondaryMentor")
     */
    private $researchAsSecondary;

    /**
     * @ORM\OneToMany(targetEntity="Research", mappedBy="thertiaryMentor")
     */
    private $researchAsThertiary;

    public function __construct() {
        $this->mentorKeywords = new ArrayCollection();
        $this->oportunitiesAsMain = new ArrayCollection();
        $this->oportunitiesAsSecondary = new ArrayCollection();
        $this->oportunitiesAsThertiary = new ArrayCollection();
        $this->researchAsMain = new ArrayCollection();
        $this->researchAsSecondary = new ArrayCollection();
        $this->researchAsThertiary = new ArrayCollection();
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
     * Set user
     *
     * @param \BackendBundle\Entity\User $user
     *
     * @return Mentor
     */
    public function setUser(\BackendBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Set uc
     *
     * @param boolean $uc
     *
     * @return Mentor
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
}

