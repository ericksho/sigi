<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ManyToOne(targetEntity="Mentor", inversedBy="researchAsMain")
     * @JoinColumn(name="mentor_id", referencedColumnName="id")
     */
    private $mainMentor;

    /**
     * @ManyToOne(targetEntity="Mentor", inversedBy="researchAsSecondary")
     * @JoinColumn(name="mentor_id", referencedColumnName="id")
     */
    private $secondaryMentor;

    /**
     * @ManyToOne(targetEntity="Mentor", inversedBy="researchAsThertiary")
     * @JoinColumn(name="mentor_id", referencedColumnName="id")
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
}

