<?php

namespace Spec\Domain\Core\ValueObject;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DescriptionSpec extends ObjectBehavior
{
    const DESCRIPTION = 'This is the description.';

    function let()
    {
        $this->beConstructedWith(self::DESCRIPTION);
    }

    function it_returns_its_value()
    {
        $this->getValue()->shouldReturn(self::DESCRIPTION);
    }

    function it_returns_empty_string_when_constructed_without_value()
    {
        $this->beConstructedWith();

        $this->getValue()->shouldReturn('');
    }

    function it_returns_empty_string_when_constructed_with_null()
    {
        $this->beConstructedWith(null);

        $this->getValue()->shouldReturn('');
    }
}
