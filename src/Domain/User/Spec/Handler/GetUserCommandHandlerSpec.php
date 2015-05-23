<?php

namespace Spec\Domain\User\Handler;

use Domain\User\Command\GetUser;
use Domain\User\Entity\User;
use Domain\User\Handler\GetUserCommandHandler;
use Domain\User\Repository\UserRepository;
use Domain\User\ValueObject\UserId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GetUserCommandHandlerSpec extends ObjectBehavior
{
    const UUID = '5399dbab-ccd0-493c-be1a-67300de1671f';

    function let(UserRepository $userRepository)
    {
        $this->beConstructedWith($userRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GetUserCommandHandler::CLASS);
    }

    function it_should_set_a_user(
        UserRepository $userRepository,
        User $user,
        GetUser $command
    ) {
        $userId = UserId::createFromString(self::UUID);

        $userRepository->findByUserId($userId)->willReturn($user);
        $userRepository->findByUserId($userId)->shouldBeCalled();

        $command->setUser($user)->shouldBeCalled();
        $command->getUserId()->shouldBeCalled();
        $command->getUserId()->willReturn($userId);

        $this->handle($command);
    }
}
