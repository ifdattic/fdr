<?php

namespace UserBundle\Security;

use Domain\User\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class SymfonyUser implements UserInterface
{
    /** @var User */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /** @return array */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /** @return string */
    public function getPassword()
    {
        return $this->user->getPassword()->getValue();
    }

    /** @return void */
    public function getSalt()
    {
    }

    /** @return string */
    public function getUsername()
    {
        return $this->user->getEmail()->getValue();
    }

    /** @return void */
    public function eraseCredentials()
    {
    }

    /** @return User */
    public function getUser()
    {
        return $this->user;
    }
}
