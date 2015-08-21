<?php

namespace Spec\UserBundle\Security\Http\Authentication;

use Domain\User\Exception\BadCredentials;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use UserBundle\Security\Http\Authentication\AuthenticationFailureHandler;

class AuthenticationFailureHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AuthenticationFailureHandler::CLASS);
    }

    function it_handles_failed_authentication(Request $request, AuthenticationException $exception)
    {
        $this
            ->shouldThrow(BadCredentials::CLASS)
            ->during('onAuthenticationFailure', [$request, $exception])
        ;
    }
}
