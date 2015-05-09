<?php

namespace Domain\User\Handler;

use Domain\Core\Identity\Uuid;
use Domain\User\Command\SignUp;
use Domain\User\Entity\User;
use Domain\User\Repository\UserRepository;
use Domain\User\ValueObject\UserId;

class SignUpCommandHandler
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(SignUp $command)
    {
        $user = new User(
            new UserId(Uuid::generate()),
            $command->getEmail(),
            $command->getFullName()
        );

        $this->userRepository->add($user);
    }
}
