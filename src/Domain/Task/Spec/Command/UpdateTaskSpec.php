<?php

namespace Spec\Domain\Task\Command;

use Domain\Core\Spec\TestValues;
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
    function let(Task $task)
    {
        $this->beConstructedWith(
            $task,
            TestValues::TASK_NAME2,
            TestValues::DATE2,
            TestValues::DESCRIPTION2,
            TestValues::ESTIMATED2,
            TestValues::COMPLETED_DATE2,
            TestValues::TIME_SPENT2,
            TestValues::IMPORTANT
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
        $this->getName()->shouldBeLike(new TaskName(TestValues::TASK_NAME2));
    }

    function it_should_return_its_date()
    {
        $this->getDate()->shouldBeLike(new \DateTime(TestValues::DATE2));
    }

    function it_should_return_its_description()
    {
        $this->getDescription()->shouldBeLike(new Description(TestValues::DESCRIPTION2));
    }

    function it_should_return_its_estimated()
    {
        $this->getEstimated()->shouldBeLike(new Estimated(TestValues::ESTIMATED2));
    }

    function it_should_return_its_completed_at()
    {
        $this->getCompletedAt()->shouldBeLike(new \DateTime(TestValues::COMPLETED_DATE2));
    }

    function it_should_return_its_time_spent()
    {
        $this->getTimeSpent()->shouldBeLike(new TimeSpent(TestValues::TIME_SPENT2));
    }

    function it_should_return_its_important()
    {
        $this->getImportant()->shouldReturn(TestValues::IMPORTANT);
    }
}
