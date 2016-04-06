<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Deadline
 *
 * @ORM\Table(name="deadline")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\DeadlineRepository")
 */
class Deadline
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
     * @ORM\Column(name="name", type="string", length=30, unique=true)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="month", type="integer")
     */
    private $month;

    /**
     * @var int
     *
     * @ORM\Column(name="day", type="integer")
     */
    private $day;


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
     * @return Deadline
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
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        $now = new \DateTime();
        $Y = $now->format('Y');

        $date = new \DateTime();
        $date->setDate($Y , $this->getMonth() , $this->getDay());
        return $date;
    }

    /**
     * Set month
     *
     * @param integer $month
     *
     * @return Deadline
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return integer
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set day
     *
     * @param integer $day
     *
     * @return Deadline
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return integer
     */
    public function getDay()
    {
        return $this->day;
    }
}
