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
     * @var bool
     *
     * @ORM\Column(name="readed", type="boolean")
     */
    private $readed;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="sendedNotifications")
     * @ORM\JoinColumn(name="sender_id", referencedColumnName="id")
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="recievedNotifications")
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
     * Get sender_id
     *
     * @return string
     */
    public function getSenderId()
    {
        return $this->sender->getId;
    }

    /**
     * Get reciever_id
     *
     * @return string
     */
    public function getRecieverId()
    {
        return $this->reciever->getId();
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

    /**
     * Set readed
     *
     * @param boolean $readed
     *
     * @return OportunityResearch
     */
    public function setReaded($readed)
    {
        $this->readed = $readed;

        return $this;
    }

    /**
     * Get readed
     *
     * @return bool
     */
    public function getReaded()
    {
        return $this->readed;
    }

    /**
     * Set sender
     *
     * @param \BackendBundle\Entity\ $sender
     *
     * @return Notification
     */
    public function setSender(\BackendBundle\Entity\User $sender)
    {
        $this->sender = $sender;
        $sender->addSendedNotification($this);

        return $this;
    }

    /**
     * Get sender
     *
     * @return \BackendBundle\Entity\User
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set reciever
     *
     * @param \BackendBundle\Entity\ $reciever
     *
     * @return Notification
     */
    public function setReciever(\BackendBundle\Entity\User $reciever)
    {
        $this->reciever = $reciever;
        $reciever->addSendedNotification($this);

        return $this;
    }

    /**
     * Get reciever
     *
     * @return \BackendBundle\Entity\User
     */
    public function getReciever()
    {
        return $this->reciever;
    }

    /**
     * Send Notification, to be used after creating a blank one
     *
     * @param \BackendBundle\Entity\User $sender
     * @param \BackendBundle\Entity\ $reciever
     * @param string $message
     * @param \DateTime $timestamp
     *
     * @return Notification
     */
    public function sendNotification(\BackendBundle\Entity\User $sender, \BackendBundle\Entity\User $reciever, $message, $timestamp)
    {
        $this->setSender($sender);
        $this->setReciever($reciever);
        $this->setMessage($message);
        $this->setTimestamp($timestamp);
        $this->setReaded(false);

        return $this;
    }
}

