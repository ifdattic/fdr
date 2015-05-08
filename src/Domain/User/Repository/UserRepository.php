<?php

namespace Domain\User\Repository;

use Domain\User\Entity\User;
use Domain\User\ValueObject\UserId;

interface UserRepository
{
    /**
     * Find user by id.
     *
     * @param  UserId $userId
     * @return User
     * @throws Domain\User\Exception\UserNotFoundException if user is not found
     */
    public function find(UserId $userId);

    public function findAll();

    public function add(User $user);

    public function remove(User $user);
}
