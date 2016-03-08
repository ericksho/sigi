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
     * @ORM\ManyToOne(targetEntity="Department", inversedBy="mentors")
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
     * Get user
     *
     * @return \BackendBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getShowName()
    {
        return $this->user->getName()." ".$this->user->getLastName();
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

    /**
     * Set OportunityResearch as Main
     *
     * @param \BackendBundle\Entity\OportunityResearch $oportunityResearch
     *
     * @return Mentor
     */
    public function addOportunityResearchAsMain(\BackendBundle\Entity\OportunityResearch $oportunityResearch)
    {
        $this->oportunitiesAsMain->add($oportunityResearch);

        return $this;
    }

    /**
     * Set OportunityResearch as Secondary
     *
     * @param \BackendBundle\Entity\OportunityResearch $oportunityResearch
     *
     * @return Mentor
     */
    public function addOportunityResearchAsSecondary(\BackendBundle\Entity\OportunityResearch $oportunityResearch)
    {
        $this->oportunitiesAsSecondary->add($oportunityResearch);

        return $this;
    }

    /**
     * Set OportunityResearch as Thertiary
     *
     * @param \BackendBundle\Entity\OportunityResearch $oportunityResearch
     *
     * @return Mentor
     */
    public function addOportunityResearchAsThertiary(\BackendBundle\Entity\OportunityResearch $oportunityResearch)
    {
        $this->oportunitiesAsThertiary->add($oportunityResearch);

        return $this;
    }

    /**
     * Delete OportunityResearch as Main
     *
     * @param \BackendBundle\Entity\OportunityResearch $oportunityResearch
     *
     * @return Mentor
     */
    public function deleteOportunityResearchAsMain(\BackendBundle\Entity\OportunityResearch $oportunityResearch)
    {
        $this->oportunitiesAsMain->removeElement($oportunityResearch);

        return $this;
    }

    /**
     * Delete OportunityResearch as Secondary
     *
     * @param \BackendBundle\Entity\OportunityResearch $oportunityResearch
     *
     * @return Mentor
     */
    public function deleteOportunityResearchAsSecondary(\BackendBundle\Entity\OportunityResearch $oportunityResearch)
    {
        $this->oportunitiesAsSecondary->removeElement($oportunityResearch);

        return $this;
    }

    /**
     * Delete OportunityResearch as Thertiary
     *
     * @param \BackendBundle\Entity\OportunityResearch $oportunityResearch
     *
     * @return Mentor
     */
    public function deleteOportunityResearchAsThertiary(\BackendBundle\Entity\OportunityResearch $oportunityResearch)
    {
        $this->oportunitiesAsThertiary->removeElement($oportunityResearch);

        return $this;
    }

    /**
     * Set department
     *
     * @param \BackendBundle\Entity\Department $department
     *
     * @return Mentor
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
     * Add mentorKeyword
     *
     * @param \BackendBundle\Entity\Keyword $mentorKeyword
     *
     * @return Mentor
     */
    public function addMentorKeyword(\BackendBundle\Entity\Keyword $mentorKeyword)
    {
        $this->mentorKeywords[] = $mentorKeyword;

        return $this;
    }

    /**
     * Remove mentorKeyword
     *
     * @param \BackendBundle\Entity\Keyword $mentorKeyword
     */
    public function removeMentorKeyword(\BackendBundle\Entity\Keyword $mentorKeyword)
    {
        $this->mentorKeywords->removeElement($mentorKeyword);
    }

    /**
     * Get mentorKeywords
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMentorKeywords()
    {
        return $this->mentorKeywords;
    }

    /**
     * Add oportunitiesAsMain
     *
     * @param \BackendBundle\Entity\OportunityResearch $oportunitiesAsMain
     *
     * @return Mentor
     */
    public function addOportunitiesAsMain(\BackendBundle\Entity\OportunityResearch $oportunitiesAsMain)
    {
        $this->oportunitiesAsMain[] = $oportunitiesAsMain;

        return $this;
    }

    /**
     * Remove oportunitiesAsMain
     *
     * @param \BackendBundle\Entity\OportunityResearch $oportunitiesAsMain
     */
    public function removeOportunitiesAsMain(\BackendBundle\Entity\OportunityResearch $oportunitiesAsMain)
    {
        $this->oportunitiesAsMain->removeElement($oportunitiesAsMain);
    }

    /**
     * Get oportunitiesAsMain
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOportunitiesAsMain()
    {
        return $this->oportunitiesAsMain;
    }

    /**
     * Add oportunitiesAsSecondary
     *
     * @param \BackendBundle\Entity\OportunityResearch $oportunitiesAsSecondary
     *
     * @return Mentor
     */
    public function addOportunitiesAsSecondary(\BackendBundle\Entity\OportunityResearch $oportunitiesAsSecondary)
    {
        $this->oportunitiesAsSecondary[] = $oportunitiesAsSecondary;

        return $this;
    }

    /**
     * Remove oportunitiesAsSecondary
     *
     * @param \BackendBundle\Entity\OportunityResearch $oportunitiesAsSecondary
     */
    public function removeOportunitiesAsSecondary(\BackendBundle\Entity\OportunityResearch $oportunitiesAsSecondary)
    {
        $this->oportunitiesAsSecondary->removeElement($oportunitiesAsSecondary);
    }

    /**
     * Get oportunitiesAsSecondary
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOportunitiesAsSecondary()
    {
        return $this->oportunitiesAsSecondary;
    }

    /**
     * Add oportunitiesAsThertiary
     *
     * @param \BackendBundle\Entity\OportunityResearch $oportunitiesAsThertiary
     *
     * @return Mentor
     */
    public function addOportunitiesAsThertiary(\BackendBundle\Entity\OportunityResearch $oportunitiesAsThertiary)
    {
        $this->oportunitiesAsThertiary[] = $oportunitiesAsThertiary;

        return $this;
    }

    /**
     * Remove oportunitiesAsThertiary
     *
     * @param \BackendBundle\Entity\OportunityResearch $oportunitiesAsThertiary
     */
    public function removeOportunitiesAsThertiary(\BackendBundle\Entity\OportunityResearch $oportunitiesAsThertiary)
    {
        $this->oportunitiesAsThertiary->removeElement($oportunitiesAsThertiary);
    }

    /**
     * Get oportunitiesAsThertiary
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOportunitiesAsThertiary()
    {
        return $this->oportunitiesAsThertiary;
    }

    /**
     * Add researchAsMain
     *
     * @param \BackendBundle\Entity\Research $researchAsMain
     *
     * @return Mentor
     */
    public function addResearchAsMain(\BackendBundle\Entity\Research $researchAsMain)
    {
        $this->researchAsMain[] = $researchAsMain;

        return $this;
    }

    /**
     * Remove researchAsMain
     *
     * @param \BackendBundle\Entity\Research $researchAsMain
     */
    public function removeResearchAsMain(\BackendBundle\Entity\Research $researchAsMain)
    {
        $this->researchAsMain->removeElement($researchAsMain);
    }

    /**
     * Get researchAsMain
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResearchAsMain()
    {
        return $this->researchAsMain;
    }

    /**
     * Add researchAsSecondary
     *
     * @param \BackendBundle\Entity\Research $researchAsSecondary
     *
     * @return Mentor
     */
    public function addResearchAsSecondary(\BackendBundle\Entity\Research $researchAsSecondary)
    {
        $this->researchAsSecondary[] = $researchAsSecondary;

        return $this;
    }

    /**
     * Remove researchAsSecondary
     *
     * @param \BackendBundle\Entity\Research $researchAsSecondary
     */
    public function removeResearchAsSecondary(\BackendBundle\Entity\Research $researchAsSecondary)
    {
        $this->researchAsSecondary->removeElement($researchAsSecondary);
    }

    /**
     * Get researchAsSecondary
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResearchAsSecondary()
    {
        return $this->researchAsSecondary;
    }

    /**
     * Add researchAsThertiary
     *
     * @param \BackendBundle\Entity\Research $researchAsThertiary
     *
     * @return Mentor
     */
    public function addResearchAsThertiary(\BackendBundle\Entity\Research $researchAsThertiary)
    {
        $this->researchAsThertiary[] = $researchAsThertiary;

        return $this;
    }

    /**
     * Remove researchAsThertiary
     *
     * @param \BackendBundle\Entity\Research $researchAsThertiary
     */
    public function removeResearchAsThertiary(\BackendBundle\Entity\Research $researchAsThertiary)
    {
        $this->researchAsThertiary->removeElement($researchAsThertiary);
    }

    /**
     * Get researchAsThertiary
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResearchAsThertiary()
    {
        return $this->researchAsThertiary;
    }
}
