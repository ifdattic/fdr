<?php

namespace Domain\Task\Entity;

use Domain\Core\ValueObject\Description;
use Domain\Task\Event\TaskWasEntered;
use Domain\Task\ValueObject\Done;
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

    /** @var \DateTimeImmutable */
    private $date;

    /** @var Estimated */
    private $estimated;

    /** @var Done */
    private $done;

    /** @var TimeSpent */
    private $timeSpent;

    public function __construct(TaskId $id, User $user, TaskName $name, \DateTimeImmutable $date)
    {
        $this->id = $id;
        $this->user = $user;
        $this->name = $name;
        $this->description = new Description();
        $this->date = $date;
        $this->estimated = new Estimated();
        $this->done = new Done();
        $this->timeSpent = new TimeSpent();

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

    /** @return \DateTimeImmutable */
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

    public function setDone(Done $done)
    {
        $this->done = $done;
    }

    /** @return Done */
    public function getDone()
    {
        return $this->done;
    }

    /** @return false */
    public function isDone()
    {
        return $this->done->getValue();
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
}
