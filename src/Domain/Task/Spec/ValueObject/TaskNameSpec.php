<?php

namespace Spec\Domain\Task\ValueObject;

use Domain\Core\Exception\AssertionFailedException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TaskNameSpec extends ObjectBehavior
{
    const NAME = 'Task Name';

    function let()
    {
        $this->beConstructedWith(self::NAME);
    }

    function it_throws_an_exception_on_empty_value()
    {
        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', [''])
        ;
    }

    function it_throws_an_exception_if_value_is_too_long()
    {
        $tooLongValue = str_repeat('i', 1029);

        $this
            ->shouldThrow(AssertionFailedException::CLASS)
            ->during('__construct', [$tooLongValue])
        ;
    }

    function it_returns_its_value()
    {
        $this->getValue()->shouldReturn(self::NAME);
    }
}
