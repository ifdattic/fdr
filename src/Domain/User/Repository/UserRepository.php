<?php

namespace Domain\User\Repository;

use Domain\User\Entity\User;
use Domain\User\ValueObject\UserId;

interface UserRepository
{
    public function find(UserId $userId);

    public function findAll();

    public function add(User $user);

    public function remove(User $user);
}
