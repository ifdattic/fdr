<?php

namespace Spec\TaskBundle\Repository;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TaskBundle\Repository\InMemoryTaskRepository;

class InMemoryTaskRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(InMemoryTaskRepository::CLASS);
    }

    function it_should_clear_all_tasks()
    {
        $this->clear();
    }
}
