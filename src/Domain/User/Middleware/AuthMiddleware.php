<?php

namespace Domain\User\Middleware;

use Domain\User\Exception\AccessDeniedException;
use Domain\User\Security\UserProvider;
use SimpleBus\Message\Bus\Middleware\MessageBusMiddleware;

abstract class AuthMiddleware implements MessageBusMiddleware
{
    /** @var UserProvider */
    protected $userProvider;

    public function __construct(UserProvider $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    /** {@inheritdoc} */
    public function handle($command, callable $next)
    {
        if ($this->applies($command)) {
            $this->beforeHandle($command);
            $next($command);
            $this->afterHandle($command);
        } else {
            $next($command);
        }
    }

    /**
     * Do auth check before the command is handled.
     *
     * @param  object $command
     * @return void
     * @throws \Exception
     */
    protected function beforeHandle($command)
    {
    }

    /**
     * Do auth check after the command is handled.
     *
     * @param  object $command
     * @return void
     * @throws \Exception
     */
    protected function afterHandle($command)
    {
    }

    /**
     * @param  string $message
     * @throws AccessDeniedException
     */
    protected function denyAccess($message = null)
    {
        throw new AccessDeniedException($message ?: 'Access Denied');
    }

    /** @return Domain\User\Entity\User */
    protected function getUser()
    {
        return $this->userProvider->getUser();
    }

    /**
     * @param  object $command
     * @return boolean
     */
    abstract protected function applies($command);
}
