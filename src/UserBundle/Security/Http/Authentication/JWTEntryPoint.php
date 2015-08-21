<?php

namespace UserBundle\Security\Http\Authentication;

use Domain\User\Exception\BadCredentials;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class JWTEntryPoint implements AuthenticationEntryPointInterface
{
    /** @inheritdoc */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        throw new BadCredentials();
    }
}
