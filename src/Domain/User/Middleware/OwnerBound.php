<?php

namespace Domain\User\Middleware;

/**
 * Interface used for when the command should check if user running the
 * command is the same user which owns the resource.
 */
interface OwnerBound
{
}
