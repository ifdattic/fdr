<?php

namespace Domain\Task\Command;

use Domain\Core\Validation\HasErrors;
use Domain\Core\Value\Description;
use Domain\Task\Entity\Task;
use Domain\Task\Value\Estimate;
use Domain\Task\Value\TaskId;
use Domain\Task\Value\TaskName;
use Domain\Task\Value\TimeSpent;

class UpdateTask
{
    use HasErrors;

    /** @var Task */
    private $task;

    /** @var string */
    private $name;

    /** @var string */
    private $date;

    /** @var string|null */
    private $description;

    /** @var integer|null */
    private $estimate;

    /** @var \DateTime|null */
    private $completedAt;

    /** @var integer|null */
    private $timeSpent;

    /** @var boolean */
    private $important;

    /**
     * @param Task $task
     * @param string $name
     * @param string $date
     * @param string|null $description
     * @param integer|null $estimate
     * @param boolean|null $done
     * @param string|null $completedAt
     * @param integer|null $timeSpent
     * @param boolean|null $important
     */
    public function __construct(
        Task $task,
        $name,
        $date,
        $description,
        $estimate,
        $completedAt,
        $timeSpent,
        $important
    ) {
        $this->task = $task;
        $this->name = $name;
        $this->date = $date;
        $this->description = $description;
        $this->estimate = $estimate;
        $this->completedAt = $completedAt;
        $this->timeSpent = $timeSpent;
        $this->important = $important;
    }

    /** @return Task */
    public function getTask()
    {
        return $this->task;
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

    /** @return Estimate */
    public function getEstimate()
    {
        return new Estimate($this->estimate);
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
        return (bool) $this->important;
    }
}
