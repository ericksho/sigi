<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Keyword
 *
 * @ORM\Table(name="keyword")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\KeywordRepository")
 */
class Keyword
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
     * @ORM\Column(name="keyword", type="string", length=20, unique=true)
     */
    private $keyword;

    /**
     * @ORM\ManyToOne(targetEntity="Mentor", inversedBy="mentorKeywords")
     * @ORM\JoinColumn(name="mentor_id", referencedColumnName="id")
     */
    private $mentor;

    /**
     * @ORM\ManyToOne(targetEntity="OportunityResearch", inversedBy="oportunityKeywords")
     * @ORM\JoinColumn(name="oportunityResearch_id", referencedColumnName="id")
     */
    private $oportunityResearch;

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
     * Set keyword
     *
     * @param string $keyword
     *
     * @return Keywords
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;

        return $this;
    }

    /**
     * Get keyword
     *
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }
}

