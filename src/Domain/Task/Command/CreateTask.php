<?php

namespace Domain\Task\Command;

use Domain\Core\ValueObject\Description;
use Domain\Task\ValueObject\Done;
use Domain\Task\ValueObject\Estimated;
use Domain\Task\ValueObject\TaskName;
use Domain\Task\ValueObject\TimeSpent;

class CreateTask
{
    /** @var string */
    private $name;

    /** @var string */
    private $date;

    /** @var string|null */
    private $description;

    /** @var integer|null */
    private $estimated;

    /** @var boolean|null */
    private $done;

    /** @var integer|null */
    private $timeSpent;

    /**
     * @param string $name
     * @param string $date
     * @param string|null $description
     * @param integer|null $estimated
     * @param boolean|null $done
     * @param integer|null $timeSpent
     */
    public function __construct($name, $date, $description, $estimated, $done, $timeSpent)
    {
        $this->name = $name;
        $this->date = $date;
        $this->description = $description;
        $this->estimated = $estimated;
        $this->done = $done;
        $this->timeSpent = $timeSpent;
    }

    /** @return TaskName */
    public function getName()
    {
        return new TaskName($this->name);
    }

    /** @return \DateTimeImmutable */
    public function getDate()
    {
        return new \DateTimeImmutable($this->date);
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

    /** @return Done */
    public function getDone()
    {
        return new Done($this->done);
    }

    /** @return TimeSpent */
    public function getTimeSpent()
    {
        return new TimeSpent($this->timeSpent);
    }
}
