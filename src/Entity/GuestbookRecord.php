<?php


namespace Guestbook\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class GuestbookRecord
 * @package Entity
 * @ORM\Entity(repositoryClass="Guestbook\Repository\GuestbookRepository")
 * @ORM\Table(name="record")
 */
class GuestbookRecord
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="create_time", nullable=false)
     */
    private $createTime;

    /**
     * @var string
     * @ORM\Column(type="text", name="text", nullable=false)
     */
    private $text;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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
     * @return \DateTime
     */
    public function getCreateTime(): \DateTime
    {
        return $this->createTime;
    }

    /**
     * @param \DateTime $createTime
     * @return GuestbookRecord
     */
    public function setCreateTime(\DateTime $createTime)
    {
        $this->createTime = $createTime;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return GuestbookRecord
     */
    public function setText(string $text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return GuestbookRecord
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
}