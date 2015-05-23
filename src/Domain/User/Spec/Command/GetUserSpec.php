<?php

namespace Spec\Domain\User\Command;

use Domain\User\Entity\User;
use Domain\User\Exception\UserNotFoundException;
use Domain\User\ValueObject\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GetUserSpec extends ObjectBehavior
{
    const UUID = '5399dbab-ccd0-493c-be1a-67300de1671f';

    function it_is_initializable()
    {
        $this->shouldHaveType('Domain\User\Command\GetUser');
    }

    function let()
    {
        $this->beConstructedWith(self::UUID);
    }

    function it_returns_its_user_id()
    {
        $this->getUserId()->shouldBeLike(UserId::createFromString(self::UUID));
    }

    function it_should_throw_an_exception_if_returning_user_without_setting_it()
    {
        $this
            ->shouldThrow(UserNotFoundException::CLASS)
            ->during('getUser')
        ;
    }

    function it_should_return_a_user_which_was_set(User $user)
    {
        $this->setUser($user);

        $this->getUser()->shouldReturn($user);
    }
}
