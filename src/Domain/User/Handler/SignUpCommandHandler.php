<?php

namespace Domain\User\Handler;

use Domain\Core\Identity\Uuid;
use Domain\User\Command\SignUp;
use Domain\User\Entity\User;
use Domain\User\Repository\UserRepository;
use Domain\User\Security\PasswordEncoder;
use Domain\User\ValueObject\PasswordHash;
use Domain\User\ValueObject\UserId;

class SignUpCommandHandler
{
    /** @var UserRepository */
    private $userRepository;

    /** @var PasswordEncoder */
    private $passwordEncoder;

    public function __construct(UserRepository $userRepository, PasswordEncoder $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function handle(SignUp $command)
    {
        $password = $this->passwordEncoder->encodePassword($command->getPassword());

        $user = new User(
            new UserId(Uuid::generate()),
            $command->getEmail(),
            $command->getFullName(),
            $password
        );

        $this->userRepository->add($user);
    }
}
