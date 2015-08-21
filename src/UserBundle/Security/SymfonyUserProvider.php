<?php

namespace UserBundle\Security;

use Domain\User\Repository\UserRepository;
use Domain\User\Security\UserProvider;
use Domain\User\Value\Email;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use UserBundle\Security\SymfonyUser;

class SymfonyUserProvider implements UserProviderInterface, UserProvider
{
    /** @var UserRepository */
    private $userRepository;

    /** @var SymfonyUser */
    private $user;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /** {@inheritdoc} */
    public function loadUserByUsername($username)
    {
        $email = new Email($username);
        $user = $this->userRepository->findByEmail($email);
        $this->user = new SymfonyUser($user);

        return $this->user;
    }

    /** {@inheritdoc} */
    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    /** {@inheritdoc} */
    public function supportsClass($class)
    {
        return 'UserBundle\Security\SymfonyUser' === $class;
    }

    /** @return Domain\User\Entity\User */
    public function getUser()
    {
        return $this->user->getUser();
    }
}
