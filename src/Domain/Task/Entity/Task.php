<?php

namespace Domain\Task\Entity;

use Domain\Core\Validation\Assert;
use Domain\Core\ValueObject\Description;
use Domain\Task\Event\TaskWasEntered;
use Domain\Task\ValueObject\Estimated;
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

    /** @var Estimated */
    private $estimated;

    /** @var \DateTime|null */
    private $completedAt;

    /** @var TimeSpent */
    private $timeSpent;

    /** @var boolean */
    private $important = true;

    public function __construct(TaskId $id, User $user, TaskName $name, \DateTime $date)
    {
        $this->id = $id;
        $this->user = $user;
        $this->name = $name;
        $this->date = $date;
        $this->description = new Description();
        $this->estimated = new Estimated();
        $this->completedAt = null;
        $this->timeSpent = new TimeSpent();
        $this->important = true;

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

    public function setEstimated(Estimated $estimated)
    {
        $this->estimated = $estimated;
    }

    /** @return Estimated */
    public function getEstimated()
    {
        return $this->estimated;
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
}
