<?php

namespace Domain\Task\Command;

use Domain\Core\Validation\HasErrorsTrait;
use Domain\Core\ValueObject\Description;
use Domain\Task\Entity\Task;
use Domain\Task\ValueObject\Estimated;
use Domain\Task\ValueObject\TaskName;
use Domain\Task\ValueObject\TimeSpent;
use Domain\User\Entity\User;

class CreateTask
{
    use HasErrorsTrait;

    /** @var User */
    private $user;

    /** @var string */
    private $name;

    /** @var string */
    private $date;

    /** @var string|null */
    private $description;

    /** @var integer|null */
    private $estimated;

    /** @var \DateTime|null */
    private $completedAt;

    /** @var integer|null */
    private $timeSpent;

    /** @var boolean */
    private $important;

    /** @var Task */
    private $task;

    /**
     * @param User $user
     * @param string $name
     * @param string $date
     * @param string|null $description
     * @param integer|null $estimated
     * @param boolean|null $done
     * @param string|null $completedAt
     * @param integer|null $timeSpent
     */
    public function __construct(User $user, $name, $date, $description, $estimated, $completedAt, $timeSpent, $important)
    {
        $this->user = $user;
        $this->name = $name;
        $this->date = $date;
        $this->description = $description;
        $this->estimated = $estimated;
        $this->completedAt = $completedAt;
        $this->timeSpent = $timeSpent;
        $this->important = $important;
    }

    /** @return User */
    public function getUser()
    {
        return $this->user;
    }

    /** @return TaskName */
    public function getName()
    {
        return new TaskName($this->name);
    }

    /** @return \DateTime */
    public function getDate()
    {
        return new \DateTime($this->date);
    }

    /** @return Description */
    public function getDescription()
    {
        return new Description($this->description);
    }

    /** @return Estimated */
    public function getEstimated()
    {
        return new Estimated($this->estimated);
    }

    /** @return \DateTime|null */
    public function getCompletedAt()
    {
        $completedAt = $this->completedAt;

        if (null !== $completedAt) {
            $completedAt = new \DateTime($completedAt);
        }

        return $completedAt;
    }

    /** @return TimeSpent */
    public function getTimeSpent()
    {
        return new TimeSpent($this->timeSpent);
    }

    /** @return boolean */
    public function getImportant()
    {
        return $this->important;
    }

    /**
     * @return Task
     * @throws \RuntimeException if task is not set
     */
    public function getTask()
    {
        if (null === $this->task) {
            throw new \RuntimeException('Task not set');
        }

        return $this->task;
    }

    public function setTask(Task $task)
    {
        $this->task = $task;
    }
}