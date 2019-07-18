<?php


namespace Guestbook\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class GuestbookRecord
 * @package Entity
 * @ORM\Entity()
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, name="user_name", nullable=false)
     */
    private $userName;

    /**
     * @var string
     * @ORM\Column(type="string", length=320, name="email", nullable=false)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=128, name="user_ip", nullable=false)
     */
    private $userIp;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     * @return User
     */
    public function setUserName(string $userName)
    {
        $this->userName = $userName;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserIp(): string
    {
        return $this->userIp;
    }

    /**
     * @param string $userIp
     * @return User
     */
    public function setUserIp(string $userIp)
    {
        $this->userIp = $userIp;
        return $this;
    }
}