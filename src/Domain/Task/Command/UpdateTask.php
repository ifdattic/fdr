<?php

namespace Domain\Task\Command;

use Domain\Core\Validation\HasErrorsTrait;
use Domain\Core\ValueObject\Description;
use Domain\Task\ValueObject\Estimated;
use Domain\Task\ValueObject\TaskId;
use Domain\Task\ValueObject\TaskName;
use Domain\Task\ValueObject\TimeSpent;

class UpdateTask
{
    use HasErrorsTrait;

    /** @var TaskId */
    private $id;

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

    /**
     * @param TaskId $id
     * @param string $name
     * @param string $date
     * @param string|null $description
     * @param integer|null $estimated
     * @param boolean|null $done
     * @param string|null $completedAt
     * @param integer|null $timeSpent
     * @param boolean|null $important
     */
    public function __construct(
        TaskId $id,
        $name,
        $date,
        $description,
        $estimated,
        $completedAt,
        $timeSpent,
        $important
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->date = $date;
        $this->description = $description;
        $this->estimated = $estimated;
        $this->completedAt = $completedAt;
        $this->timeSpent = $timeSpent;
        $this->important = $important;
    }

    /** @return TaskId */
    public function getId()
    {
        return $this->id;
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
}
