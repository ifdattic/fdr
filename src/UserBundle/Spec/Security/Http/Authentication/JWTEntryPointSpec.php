<?php

namespace Spec\UserBundle\Security\Http\Authentication;

use Domain\User\Exception\BadCredentials;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use UserBundle\Security\Http\Authentication\JWTEntryPoint;

class JWTEntryPointSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(JWTEntryPoint::CLASS);
        $this->shouldHaveType(AuthenticationEntryPointInterface::CLASS);
    }

    function it_handles_failed_authentication(Request $request, AuthenticationException $authException)
    {
        $this
            ->shouldThrow(BadCredentials::CLASS)
            ->during('start', [$request, $authException])
        ;
    }
}
