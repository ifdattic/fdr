<?php

namespace Spec\Domain\User\Event;

use Domain\Core\Identity\Uuid;
use Domain\User\ValueObject\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserWasEnteredSpec extends ObjectBehavior
{
    const VALID_UUID = '5399dbab-ccd0-493c-be1a-67300de1671f';

    function it_returns_user_id()
    {
        $userId = new UserId(new Uuid(self::VALID_UUID));
        $this->beConstructedWith($userId);

        $this->getUserId()->shouldReturn($userId);
    }
}
