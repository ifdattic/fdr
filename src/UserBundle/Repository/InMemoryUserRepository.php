<?php

namespace UserBundle\Repository;

use Domain\User\Entity\User;
use Domain\User\Exception\UserNotFoundException;
use Domain\User\Repository\UserRepository;
use Domain\User\Value\Email;
use Domain\User\Value\UserId;

class InMemoryUserRepository implements UserRepository
{
    private $users = [];

    /** {@inheritdoc} */
    public function clear()
    {
        $this->users = [];
    }

    /** {@inheritdoc} */
    public function find($id)
    {
        $this->findByUserId(new UserId($id));
    }

    /** {@inheritdoc} */
    public function findByUserId(UserId $userId)
    {
        foreach ($this->users as $user) {
            if ($userId == $user->getId()) {
                return $user;
            }
        }

        throw new UserNotFoundException();
    }

    /** {@inheritdoc} */
    public function findByEmail(Email $email)
    {
        foreach ($this->users as $user) {
            if ($email == $user->getEmail()) {
                return $user;
            }
        }

        throw new UserNotFoundException();
    }

    /** {@inheritdoc} */
    public function add(User $user)
    {
        $this->users[] = $user;
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
