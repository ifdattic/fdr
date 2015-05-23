<?php

namespace Domain\User\Handler;

use Domain\User\Command\GetUser;
use Domain\User\Repository\UserRepository;

class GetUserCommandHandler
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(GetUser $command)
    {
        $userId = $command->getUserId();
        $user = $this->userRepository->findByUserId($userId);

        $command->setUser($user);
    }
}
