<?php

namespace AppBundle\Middleware;

use AppBundle\Validation\Validator;
use Domain\Core\Validation\HasErrorsTrait;
use SimpleBus\Message\Bus\Middleware\MessageBusMiddleware;

class CommandValidatorMiddleware implements MessageBusMiddleware
{
    /** @var Validator */
    private $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /** {@inheritdoc} */
    public function handle($command, callable $next)
    {
        $traits = class_uses($command);

        // Command isn't worried about validation, continue on
        if (false === $traits || !in_array(HasErrorsTrait::CLASS, $traits)) {
            $next($command);

            return;
        }

        // Validate the command and bail if errors
        $errors = $this->validator->validate($command);

        if (count($errors) > 0) {
            $command->addErrors($errors);

            return;
        }

        // No errors, continue on
        $next($command);
    }
}