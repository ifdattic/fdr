<?php

namespace Domain\Task\Entity;

use Domain\Core\Validation\Assert;
use Domain\Core\ValueObject\Description;
use Domain\Task\Event\TaskWasEntered;
use Domain\Task\ValueObject\Estimate;
use Domain\Task\ValueObject\TaskId;
use Domain\Task\ValueObject\TaskName;
use Domain\Task\ValueObject\TimeSpent;
use Domain\User\Entity\User;
use SimpleBus\Message\Recorder\ContainsRecordedMessages;
use SimpleBus\Message\Recorder\PrivateMessageRecorderCapabilities;

class Task implements ContainsRecordedMessages
{
    use PrivateMessageRecorderCapabilities;

    /** @var TaskId */
    private $id;

    /** @var User */
    private $user;

    /** @var TaskName */
    private $name;

    /** @var Description */
    private $description;

    /** @var \DateTime */
    private $date;

    /** @var Estimate */
    private $estimate;

    /** @var \DateTime|null */
    private $completedAt;

    /** @var TimeSpent */
    private $timeSpent;

    /** @var boolean */
    private $important = true;

    /** @var \DateTime */
    private $createdAt;

    public function __construct(TaskId $id, User $user, TaskName $name, \DateTime $date)
    {
        $this->id = $id;
        $this->user = $user;
        $this->name = $name;
        $this->date = $date;
        $this->description = new Description();
        $this->estimate = new Estimate();
        $this->completedAt = null;
        $this->timeSpent = new TimeSpent();
        $this->important = true;
        $this->createdAt = new \DateTime();

        $this->record(new TaskWasEntered($id));
    }

    /** @return TaskId */
    public function getId()
    {
        return $this->id;
    }

    /** @return User */
    public function getUser()
    {
        return $this->user;
    }

    /** @return TaskName */
    public function getName()
    {
        return $this->name;
    }

    public function setName(TaskName $name)
    {
        $this->name = $name;
    }

    public function setDescription(Description $description)
    {
        $this->description = $description;
    }

    /** @return Description */
    public function getDescription()
    {
        return $this->description;
    }

    /** @return \DateTime */
    public function getDate()
    {
        return $this->date;
    }

    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    public function setEstimate(Estimate $estimate)
    {
        $this->estimate = $estimate;
    }

    /** @return Estimate */
    public function getEstimate()
    {
        return $this->estimate;
    }

    /** @return \DateTime|null */
    public function getCompletedAt()
    {
        return $this->completedAt;
    }

    public function setCompletedAt(\DateTime $completedAt = null)
    {
        $this->completedAt = $completedAt;
    }

    /** @return boolean */
    public function isCompleted()
    {
        return null !== $this->completedAt;
    }

    public function setTimeSpent(TimeSpent $timeSpent)
    {
        $this->timeSpent = $timeSpent;
    }

    /** @return TimeSpent */
    public function getTimeSpent()
    {
        return $this->timeSpent;
    }

    /** @return boolean */
    public function isImportant()
    {
        return $this->important;
    }

    /** @param boolean $important */
    public function setImportant($important)
    {
        Assert::boolean($important);

        $this->important = $important;
    }

    /** @return \DateTime */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
