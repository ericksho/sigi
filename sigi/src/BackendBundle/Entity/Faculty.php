<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Faculty
 *
 * @ORM\Table(name="faculty")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\FacultyRepository")
 */
class Faculty
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
     * @ORM\Column(name="name", type="string", length=100, unique=true)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Department", inversedBy="faculty")
     * @ORM\JoinTable(name="departments_faculties")
     */
    private $departments;

    /**
     * @ORM\OneToMany(targetEntity="OportunityResearch", mappedBy="faculty")
     */
    private $oportunities;

    public function __construct() {
        $this->departments = new ArrayCollection();
        $this->oportunities = new ArrayCollection();
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
     * @return Faculty
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
     * Get departments
     *
     * @return \BackendBundle\Entity\Department
     */
    public function getDepartments()
    {
        return $this->departments;
    }

    /**
     * Get departments
     *
     * @return array
     */
    public function getDepartmentsArray()
    {
        $departments = $this->departments->getValues();

        return $departments;
    }

    /**
     * Add department
     *
     * @param \BackendBundle\Entity\Department $departments
     *
     * @return Faculty
     */
    public function addDepartment(\BackendBundle\Entity\Department $department)
    {
        $this->departments->add($department);
        return $this;
    }

    /**
     * Delete department
     *
     * @param \BackendBundle\Entity\Department $department
     *
     * @return Faculty
     */
    public function removeDepartment(\BackendBundle\Entity\Department $department)
    {
        $this->departments->removeElement($department);
        return $this;
    }

    /**
     * Add department
     *
     * @param \BackendBundle\Entity\Department $department
     *
     * @return Faculty
     */
    public function setDepartment(ArrayCollection $department)
    {
        $this->departments = $department;
        return $this;
    }
}
