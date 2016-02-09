<?php
namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="BackendBundle\Repository\UserRepository")
 */
class User  implements UserInterface, \Serializable
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
    * @ORM\OneToOne(targetEntity="Mentor", mappedBy="user", cascade={"persist"})
    */
    private $mentor;

    /**
    * @ORM\OneToOne(targetEntity="Other", mappedBy="user", cascade={"persist"})
    */
    private $other;

    /**
    * @ORM\OneToOne(targetEntity="Student", mappedBy="user", cascade={"persist"})
    */
    private $student;

    /**
     * @ORM\OneToMany(targetEntity="Notification", mappedBy="sender")
     */
    private $sendedNotifications;

    /**
     * @ORM\OneToMany(targetEntity="Notification", mappedBy="reciever")
     */
    private $recievedNotifications;

    public function __construct() {
        $this->features = new ArrayCollection();
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid(null, true));
    }
    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=20)
     */
    private $role;
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=25, unique=true)
     */
    private $username;
    /**
     * @var int
     *
     * @ORM\Column(name="rut", type="integer", unique=true)
     */
    private $rut;
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=20)
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=20)
     */
    private $lastName;
    /**
     * @var string
     *
     * @ORM\Column(name="middle_name", type="string", length=20)
     */
    private $middleName;
    /**
     * @var string
     *
     * @ORM\Column(name="second_surname", type="string", length=20)
     */
    private $secondSurname;
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=254, unique=true)
     */
    private $email;
    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=30, nullable=true, unique=true)
     */
    private $phone;
    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    private $picture;
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
     * Set role
     *
     * @param string $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }
    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }
    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUserName($username)
    {
        $this->username = $username;
        return $this;
    }
    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        //return $this->username;
        return $this->name." ".$this->lastName;
    }
    /**
     * Set rut
     *
     * @param integer $rut
     *
     * @return User
     */
    public function setRut($rut)
    {
        $this->rut = $rut;
        return $this;
    }
    /**
     * Get rut
     *
     * @return int
     */
    public function getRut()
    {
        return $this->rut;
    }
    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
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
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }
    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    /**
     * Set middleName
     *
     * @param string $middleName
     *
     * @return User
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
        return $this;
    }
    /**
     * Get middleName
     *
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }
    /**
     * Set secondSurname
     *
     * @param string $secondSurname
     *
     * @return User
     */
    public function setSecondSurname($secondSurname)
    {
        $this->secondSurname = $secondSurname;
        return $this;
    }
    /**
     * Get secondSurname
     *
     * @return string
     */
    public function getSecondSurname()
    {
        return $this->secondSurname;
    }
    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }
    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }
    /**
     * Set picture
     *
     * @param string $picture
     *
     * @return User
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
        return $this;
    }
    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @Assert\NotBlank(message="Debe ingresar contraseña")
     * @Assert\Length(
     *      min = "5",
     *      max = "12",
     *      minMessage = "Contraseña debe ser de almenos 5 caracteres",
     *      maxMessage = "Contraseña debe ser de menos de 12 caracteres",
     *      groups = {"Default"}
     * )
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        if (strlen($password) > 4) {
            $this->plainPassword = $password;
        }
        else
        {
            $this->plainPassword = $this->plainPassword;   
        }
    }

    public function setPassword($password)
    {
        if (strlen($password)>4) {
            $this->password = $password;
        }
        else
            $this->password = $this->password;

    }

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        return array($this->role);
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set mentor
     *
     * @param \BackendBundle\Entity\Mentor $mentor
     *
     * @return User
     */
    public function setMentor(\BackendBundle\Entity\Mentor $mentor = null)
    {
        $this->mentor = $mentor;
        $mentor->setUser($this);

        return $this;
    }

    /**
     * Get mentor
     *
     * @return \BackendBundle\Entity\Mentor
     */
    public function getMentor()
    {
        return $this->mentor;
    }

    /**
     * Set other
     *
     * @param \BackendBundle\Entity\Other $other
     *
     * @return User
     */
    public function setOther(\BackendBundle\Entity\Other $other = null)
    {
        $this->other = $other;
        $other->setUser($this);

        return $this;
    }

    /**
     * Get other
     *
     * @return \BackendBundle\Entity\Other
     */
    public function getOther()
    {
        return $this->other;
    }

    /**
     * Set student
     *
     * @param \BackendBundle\Entity\Student $student
     *
     * @return User
     */
    public function setStudent(\BackendBundle\Entity\Student $student)
    {
        $this->student = $student;
        $student->setUser($this);

        return $this;
    }

    /**
     * Get student
     *
     * @return \BackendBundle\Entity\Student
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Add sendedNotification
     *
     * @param \BackendBundle\Entity\Notification $sendedNotification
     *
     * @return User
     */
    public function addSendedNotification(\BackendBundle\Entity\Notification $sendedNotification)
    {
        $this->sendedNotifications[] = $sendedNotification;

        return $this;
    }

    /**
     * Remove sendedNotification
     *
     * @param \BackendBundle\Entity\Notification $sendedNotification
     */
    public function removeSendedNotification(\BackendBundle\Entity\Notification $sendedNotification)
    {
        $this->sendedNotifications->removeElement($sendedNotification);
    }

    /**
     * Get sendedNotifications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSendedNotifications()
    {
        return $this->sendedNotifications;
    }

    /**
     * Add recievedNotification
     *
     * @param \BackendBundle\Entity\Notification $recievedNotification
     *
     * @return User
     */
    public function addRecievedNotification(\BackendBundle\Entity\Notification $recievedNotification)
    {
        $this->recievedNotifications[] = $recievedNotification;

        return $this;
    }

    /**
     * Remove recievedNotification
     *
     * @param \BackendBundle\Entity\Notification $recievedNotification
     */
    public function removeRecievedNotification(\BackendBundle\Entity\Notification $recievedNotification)
    {
        $this->recievedNotifications->removeElement($recievedNotification);
    }

    /**
     * Get recievedNotifications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecievedNotifications()
    {
        return $this->recievedNotifications;
    }
}
