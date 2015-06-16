<?php

namespace Domain\User\Middleware;

use Domain\User\Middleware\AuthMiddleware;
use Domain\User\Middleware\OwnerBound;

class OwnerBoundMiddleware extends AuthMiddleware
{
    /** {@inheritdoc} */
    protected function afterHandle($command)
    {
        if ($command->getUser() !== $this->getUser()) {
            $this->denyAccess();
        }
    }

    /** {@inheritdoc} */
    protected function applies($command)
    {
        return ($command instanceof OwnerBound);
    }
}
