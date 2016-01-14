<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\NotificationRepository")
 */
class Notification
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
     * @ORM\Column(name="message", type="string", length=255)
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="sender")
     * @ORM\JoinColumn(name="sender_id", referencedColumnName="id")
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="reciever")
     * @ORM\JoinColumn(name="reciever_id", referencedColumnName="id")
     */
    private $reciever;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime")
     */
    private $timestamp;


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
     * Set message
     *
     * @param string $message
     *
     * @return Notification
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set sender_id
     *
     * @param integer $sender_id
     *
     * @return Notification
     */
    public function setSenderId($sender_id)
    {
        $this->sender_id = $sender_id;

        return $this;
    }

    /**
     * Get sender_id
     *
     * @return string
     */
    public function getSenderId()
    {
        return $this->sender_id;
    }

    /**
     * Set reciever_id
     *
     * @param integer $reciever_id
     *
     * @return Notification
     */
    public function setRecieverId($reciever_id)
    {
        $this->reciever_id = $reciever_id;

        return $this;
    }

    /**
     * Get reciever_id
     *
     * @return string
     */
    public function getRecieverId()
    {
        return $this->reciever_id;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return Notification
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}

