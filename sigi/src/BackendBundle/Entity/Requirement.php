<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Requirement
 *
 * @ORM\Table(name="requirement")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\RequirementRepository")
 */
class Requirement
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
     * @ORM\Column(name="description", type="string", length=255, unique=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="function", type="string", length=255, unique=true)
     */
    private $function;

    /**
     * @ORM\ManyToMany(targetEntity="OportunityResearch", mappedBy="requirements")
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
     * Set description
     *
     * @param string $description
     *
     * @return Requirement
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
     * Set type
     *
     * @param string $type
     *
     * @return Requirement
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integet
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set function
     *
     * @param string $function
     *
     * @return Requirement
     */
    public function setFunction($function)
    {
        $this->function = $function;

        return $this;
    }

    /**
     * Get function
     *
     * @return string
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * Get text of type
     *
     * @return string
     */
    public function getTextType()
    {
        switch ($this->type) {
            case 1:
                $text = "Ramo (prerequisito)";
                break;
            case 2:
                $text = "Carrera/area";
                break;
            case 3:
                $text = "Creditos";
                break;
            default:
                $text = "indefinido";
                break;
        }
        return $text;
    }

    /**
     * Set type by text
     *
     * @param string $function
     *
     * @return int
     */
    public function setTypeByText($text)
    {
        switch ($text) {
            case "Ramo (prerequisito)":
                $type = 1;
                break;
            case "Carrera/area":
                $type = 2;
                break;
            case "Creditos":
                $type = 3;
                break;
            default:
                $type = 0;
                break;
        }
        $this->type = $type;
        return $this;
    }
}

