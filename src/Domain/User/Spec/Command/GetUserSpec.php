<?php

namespace Spec\Domain\User\Command;

use Domain\Core\Spec\TestValues;
use Domain\User\Command\GetUser;
use Domain\User\Entity\User;
use Domain\User\Value\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GetUserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(GetUser::CLASS);
    }

    function let()
    {
        $this->beConstructedWith(TestValues::UUID);
    }

    function it_returns_its_user_id()
    {
        $this->getUserId()->shouldBeLike(UserId::createFromString(TestValues::UUID));
    }

    function it_should_throw_an_exception_if_returning_user_without_setting_it()
    {
        $this
            ->shouldThrow(\RuntimeException::CLASS)
            ->during('getUser')
        ;
    }

    function it_should_return_a_user_which_was_set(User $user)
    {
        $this->setUser($user);

        $this->getUser()->shouldReturn($user);
    }
}
