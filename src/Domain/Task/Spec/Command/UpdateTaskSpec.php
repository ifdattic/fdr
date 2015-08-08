<?php

namespace Spec\Domain\Task\Command;

use Domain\Core\ValueObject\Description;
use Domain\Task\Command\UpdateTask;
use Domain\Task\Entity\Task;
use Domain\Task\ValueObject\Estimated;
use Domain\Task\ValueObject\TaskName;
use Domain\Task\ValueObject\TimeSpent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UpdateTaskSpec extends ObjectBehavior
{
    const COMPLETED_DATE2 = '2015-06-15 17:34:55';
    const DATE2           = '2015-06-15';
    const DESCRIPTION2    = 'Alternative description';
    const ESTIMATED2      = 2;
    const IMPORTANT2      = true;
    const TASK_NAME2      = 'Alternative Task Name';
    const TIME_SPENT2     = 22;

    function let(Task $task)
    {
        $this->beConstructedWith(
            $task,
            self::TASK_NAME2,
            self::DATE2,
            self::DESCRIPTION2,
            self::ESTIMATED2,
            self::COMPLETED_DATE2,
            self::TIME_SPENT2,
            self::IMPORTANT2
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpdateTask::CLASS);
    }

    function it_should_return_its_task(Task $task)
    {
        $this->getTask()->shouldReturn($task);
    }

    function it_should_return_its_name()
    {
        $this->getName()->shouldBeLike(new TaskName(self::TASK_NAME2));
    }

    function it_should_return_its_date()
    {
        $this->getDate()->shouldBeLike(new \DateTime(self::DATE2));
    }

    function it_should_return_its_description()
    {
        $this->getDescription()->shouldBeLike(new Description(self::DESCRIPTION2));
    }

    function it_should_return_its_estimated()
    {
        $this->getEstimated()->shouldBeLike(new Estimated(self::ESTIMATED2));
    }

    function it_should_return_its_completed_at()
    {
        $this->getCompletedAt()->shouldBeLike(new \DateTime(self::COMPLETED_DATE2));
    }

    function it_should_return_its_time_spent()
    {
        $this->getTimeSpent()->shouldBeLike(new TimeSpent(self::TIME_SPENT2));
    }

    function it_should_return_its_important()
    {
        $this->getImportant()->shouldReturn(self::IMPORTANT2);
    }
}
