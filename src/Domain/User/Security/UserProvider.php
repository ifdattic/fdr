<?php

namespace Domain\User\Security;

interface UserProvider
{
    /**
     * Get current user.
     *
     * @return Domain\User\Entity\User|null
     */
    public function getUser();
}
