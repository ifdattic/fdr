<?php

namespace Spec\Domain\User\Middleware;

use Domain\Task\Command\CreateTask;
use Domain\Task\Command\GetTask;
use Domain\User\Entity\User;
use Domain\User\Exception\AccessDeniedException;
use Domain\User\Middleware\AuthMiddleware;
use Domain\User\Middleware\OwnerBoundMiddleware;
use Domain\User\Security\UserProvider;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OwnerBoundMiddlewareSpec extends ObjectBehavior
{
    function let(UserProvider $userProvider)
    {
        $this->beConstructedWith($userProvider);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OwnerBoundMiddleware::CLASS);
        $this->shouldHaveType(AuthMiddleware::CLASS);
    }

    function it_should_skip_owner_check_if_command_not_owner_bound(CreateTask $command)
    {
        $callable = function () {};

        $this->handle($command, $callable);
    }

    function it_should_throw_an_exception_if_not_an_owner(
        UserProvider $userProvider,
        User $currentUser,
        GetTask $command,
        User $user
    ) {
        $callable = function () {};

        $userProvider->getUser()->shouldBeCalled()->willReturn($currentUser);
        $command->getUser()->shouldBeCalled()->willReturn($user);

        $this
            ->shouldThrow(AccessDeniedException::CLASS)
            ->during('handle', [$command, $callable])
        ;
    }

    function it_should_not_throw_an_exception_if_an_owner(
        UserProvider $userProvider,
        GetTask $command,
        User $user
    ) {
        $callable = function () {};

        $userProvider->getUser()->shouldBeCalled()->willReturn($user);
        $command->getUser()->shouldBeCalled()->willReturn($user);

        $this->handle($command, $callable);
    }
}
