<?php

namespace spec\Domain\User\Handler;

use Domain\User\Command\SignUp;
use Domain\User\Entity\User;
use Domain\User\Handler\SignUpCommandHandler;
use Domain\User\Repository\UserRepository;
use Domain\User\ValueObject\Email;
use Domain\User\ValueObject\FullName;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SignUpCommandHandlerSpec extends ObjectBehavior
{
    const EMAIL    = 'virgil@mundell.com';
    const FULLNAME = 'Virgil Mundell';

    function let(UserRepository $userRepository)
    {
        $this->beConstructedWith($userRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SignUpCommandHandler::CLASS);
    }

    function it_should_persist_valid_data(
        UserRepository $userRepository,
        SignUp $command
    ) {
        $command->getEmail()->willReturn(new Email(self::EMAIL));
        $command->getFullName()->willReturn(new FullName(self::FULLNAME));
        $user = Argument::type(User::CLASS);

        $userRepository->add($user)->shouldBeCalled();

        $this->handle($command);
    }
}
