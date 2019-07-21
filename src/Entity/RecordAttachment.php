<?php

namespace Guestbook\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class File
 * @package Entity
 * @ORM\Entity
 * @ORM\Table(name="record_attachment")
 */
class RecordAttachment
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var GuestbookRecord
     * @ORM\OneToOne(targetEntity="GuestbookRecord", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="record_id", referencedColumnName="id")
     */
    private $recordId;

    /**
     * @ORM\Column(type="string", length=250, name="file_name", nullable=false)
     */
    private $fileName;

    /**
     * @var @ORM\Column(type="string", length=250, name="content_path", nullable=false)
     */
    private $contentPath;

    /**
     * @var @ORM\Column(type="string", length=250, name="content_type")
     */
    private $contentType;

    /**
     * @var @ORM\Column(type="string", length=30, name="content_size")
     */
    private $contentSize;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return GuestbookRecord
     */
    public function getRecordId(): GuestbookRecord
    {
        return $this->recordId;
    }

    /**
     * @param GuestbookRecord $recordId
     * @return RecordAttachment
     */
    public function setRecordId(GuestbookRecord $recordId)
    {
        $this->recordId = $recordId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param mixed $fileName
     * @return RecordAttachment
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param mixed $contentType
     * @return RecordAttachment
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContentSize()
    {
        return $this->contentSize;
    }

    /**
     * @param mixed $contentSize
     * @return RecordAttachment
     */
    public function setContentSize($contentSize)
    {
        $this->contentSize = $contentSize;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContentPath()
    {
        return $this->contentPath;
    }

    /**
     * @param mixed $contentPath
     * @return RecordAttachment
     */
    public function setContentPath($contentPath)
    {
        $this->contentPath = $contentPath;
        return $this;
    }
}