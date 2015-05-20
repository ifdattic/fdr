<?php

namespace AppBundle\Repository;

use Domain\User\Entity\User;
use Domain\User\Exception\UserNotFoundException;
use Domain\User\Repository\UserRepository;
use Domain\User\ValueObject\Email;
use Domain\User\ValueObject\UserId;

class InMemoryUserRepository implements UserRepository
{
    private $users = [];

    /** {@inheritDocs} */
    public function clear()
    {
        $this->users = [];
    }

    /** {@inheritDocs} */
    public function findByUserId(UserId $userId)
    {
        foreach ($this->users as $user) {
            if ($userId == $user->getId()) {
                return $user;
            }
        }

        throw new UserNotFoundException();
    }

    public function findAll()
    {
        return $this->users;
    }

    public function add(User $user)
    {
        $this->users[] = $user;
    }

    public function remove(User $user)
    {

    }

    /** {@inheritdocs} */
    public function isEmailUnique(Email $email)
    {
        foreach ($this->users as $user) {
            if ($email == $user->getEmail()) {
                return false;
            }
        }

        return true;
    }
}
