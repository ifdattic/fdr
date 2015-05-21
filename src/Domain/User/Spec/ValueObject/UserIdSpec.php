<?php

namespace Spec\Domain\User\ValueObject;

use Domain\Core\Identity\Uuid;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserIdSpec extends ObjectBehavior
{
    const VALID_UUID = '5399dbab-ccd0-493c-be1a-67300de1671f';

    function it_returns_its_value()
    {
        $uuid = new Uuid(self::VALID_UUID);

        $this->beConstructedWith($uuid);

        $this->getValue()->shouldReturn(self::VALID_UUID);
    }
}
