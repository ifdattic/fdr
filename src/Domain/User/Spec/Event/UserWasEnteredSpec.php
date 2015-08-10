<?php

namespace Spec\Domain\User\Event;

use Domain\Core\Identity\Uuid;
use Domain\Core\Spec\TestValues;
use Domain\User\ValueObject\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserWasEnteredSpec extends ObjectBehavior
{
    function it_returns_user_id()
    {
        $userId = new UserId(new Uuid(TestValues::UUID));
        $this->beConstructedWith($userId);

        $this->getUserId()->shouldReturn($userId);
    }
}
