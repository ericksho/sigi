<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Department
 *
 * @ORM\Table(name="department")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\DepartmentRepository")
 */
class Department
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
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Faculty", inversedBy="departments")
     * @ORM\JoinColumn(name="faculty_id", referencedColumnName="id")
     */
    private $faculty;

    /**
     * @ORM\OneToMany(targetEntity="Mentor", mappedBy="department")
     */
    private $mentors;

    public function __construct() {
        $this->mentors = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Department
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
     * Get faculty
     *
     * @return string
     */
    public function getFaculty()
    {
        return $this->faculty;
    }

    /**
     * Set faculty
     *
     * @param \BackendBundle\Entity\Faculty $faculty
     *
     * @return Department
     */
    public function setFaculty(\BackendBundle\Entity\Faculty $faculty)
    {
        $this->faculty = $faculty;

        return $this;
    }
}

