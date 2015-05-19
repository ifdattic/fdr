<?php

namespace AppBundle\Repository;

use Domain\Core\Identity\Uuid;
use Domain\User\Entity\User;
use Domain\User\Exception\UserNotFoundException;
use Domain\User\Repository\UserRepository;
use Domain\User\ValueObject\Email;
use Domain\User\ValueObject\FullName;
use Domain\User\ValueObject\PasswordHash;
use Domain\User\ValueObject\UserId;

class InMemoryUserRepository implements UserRepository
{
    private $users;

    public function __construct()
    {
        $this->users[] = new User(
            new UserId(new Uuid('8ce05088-ed1f-43e9-a415-3b3792655a9b')),
            new Email('john@doe.com'),
            new FullName('John Doe'),
            new PasswordHash('$2y$04$ZpNmuQAE0roOG.UnpEFErOuZ0fFMXmMDoojuzmbvOwhYOKT9SJgB2')
        );

        $this->users[] = new User(
            new UserId(new Uuid('62a0ceb4-0403-4aa6-a6cd-1ee808ad4d23')),
            new Email('jean@bon.com'),
            new FullName('Jean Bon'),
            new PasswordHash('$2y$04$dWGqp58K1Xjr5tJUX/5TjOgWUBqC9EnPS8/sLog35cC46FJZh20QW')
        );
    }

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
}
