<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    * @OneToOne(targetEntity="User", inversedBy="mentor")
    * @JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;

    /**
     * @var bool
     *
     * @ORM\Column(name="uc", type="boolean")
     */
    private $uc;

    /**
     * @ManyToOne(targetEntity="Department")
     * @JoinColumn(name="department_id", referencedColumnName="id")
     */
    private $department;

    /**
     * @OneToMany(targetEntity="Keyword", mappedBy="mentor")
     */
    private $mentorKeywords;

    /**
     * @OneToMany(targetEntity="OportunityResearch", mappedBy="mainMentor")
     */
    private $oportunitiesAsMain;

    /**
     * @OneToMany(targetEntity="OportunityResearch", mappedBy="secondaryMentor")
     */
    private $oportunitiesAsSecondary;

    /**
     * @OneToMany(targetEntity="OportunityResearch", mappedBy="thertiaryMentor")
     */
    private $oportunitiesAsThertiary;

    /**
     * @OneToMany(targetEntity="Research", mappedBy="mainMentor")
     */
    private $researchAsMain;

    /**
     * @OneToMany(targetEntity="Research", mappedBy="secondaryMentor")
     */
    private $researchAsSecondary;

    /**
     * @OneToMany(targetEntity="Research", mappedBy="thertiaryMentor")
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

