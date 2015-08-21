<?php

namespace UserBundle\Security\Http\Authentication;

use Domain\User\Exception\BadCredentials;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

class AuthenticationFailureHandler implements AuthenticationFailureHandlerInterface
{
    /** @inheritdoc */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        throw new BadCredentials();
    }
}
