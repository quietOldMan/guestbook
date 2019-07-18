<?php

namespace Guestbook\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserAgent
 * @package Entity
 * @ORM\Entity()
 * @ORM\Table(name="user_agent")
 */
class UserAgent
{
    /**
     * @var User
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     * @ORM\Column(type="text", name="user_agent", nullable=false)
     */
    private $userAgent;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return UserAgent
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    /**
     * @param string $userAgent
     * @return UserAgent
     */
    public function setUserAgent(string $userAgent)
    {
        $this->userAgent = $userAgent;
        return $this;
    }
}