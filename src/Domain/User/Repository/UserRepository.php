<?php

namespace Domain\User\Repository;

use Domain\User\Entity\User;
use Domain\User\ValueObject\Email;
use Domain\User\ValueObject\UserId;

interface UserRepository
{
    /**
     * Clear all users.
     *
     * @return void
     */
    public function clear();

    /**
     * Find user by id.
     *
     * @param  UserId $userId
     * @return User
     * @throws Domain\User\Exception\UserNotFoundException if user is not found
     */
    public function findByUserId(UserId $userId);

    /**
     * Find user by email.
     *
     * @param  Email  $email
     * @return User
     * @throws Domain\User\Exception\UserNotFoundException if user is not found
     */
    public function findByEmail(Email $email);

    public function findAll();

    /**
     * Add a user.
     *
     * @param User $user
     */
    public function add(User $user);

    public function remove(User $user);

    /**
     * Check if email is unique (no user with this email).
     *
     * @param  Email   $email
     * @return boolean        true if email is unique, false otherwise
     */
    public function isEmailUnique(Email $email);
}
