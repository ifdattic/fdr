<?php

namespace Spec\Domain\User\Handler;

use Domain\Core\Spec\TestValues;
use Domain\User\Command\SignUp;
use Domain\User\Entity\User;
use Domain\User\Handler\SignUpCommandHandler;
use Domain\User\Repository\UserRepository;
use Domain\User\Security\PasswordEncoder;
use Domain\User\ValueObject\Email;
use Domain\User\ValueObject\FullName;
use Domain\User\ValueObject\Password;
use Domain\User\ValueObject\PasswordHash;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SignUpCommandHandlerSpec extends ObjectBehavior
{
    function let(UserRepository $userRepository, PasswordEncoder $passwordEncoder)
    {
        $this->beConstructedWith($userRepository, $passwordEncoder);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SignUpCommandHandler::CLASS);
    }

    function it_should_persist_valid_data(
        UserRepository $userRepository,
        PasswordEncoder $passwordEncoder,
        SignUp $command
    ) {
        $command->getEmail()->willReturn(new Email(TestValues::EMAIL));
        $command->getFullName()->willReturn(new FullName(TestValues::FULLNAME));
        $command->getPassword()->willReturn(new Password(TestValues::PASSWORD));
        $passwordEncoder
            ->encodePassword(Argument::type(Password::CLASS))
            ->willReturn(new PasswordHash(TestValues::PASSWORD_HASH))
        ;
        $user = Argument::type(User::CLASS);

        $userRepository->add($user)->shouldBeCalled();

        $this->handle($command);
    }
}
