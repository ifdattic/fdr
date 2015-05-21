<?php

namespace Spec\Domain\User\Handler;

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
    const EMAIL         = 'virgil@mundell.com';
    const FULLNAME      = 'Virgil Mundell';
    const PASSWORD      = '9wt24yk^T&ObwHDQ2bbDej3kZ^Llz@';
    const PASSWORD_HASH = '$2y$14$2RfLwLL./bzTyfNdBRaotelrsmoOR61yUcDTOIDT84VwvvvZA7zJW';

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
        $command->getEmail()->willReturn(new Email(self::EMAIL));
        $command->getFullName()->willReturn(new FullName(self::FULLNAME));
        $command->getPassword()->willReturn(new Password(self::PASSWORD));
        $passwordEncoder
            ->encodePassword(Argument::type(Password::CLASS))
            ->willReturn(new PasswordHash(self::PASSWORD_HASH))
        ;
        $user = Argument::type(User::CLASS);

        $userRepository->add($user)->shouldBeCalled();

        $this->handle($command);
    }
}
