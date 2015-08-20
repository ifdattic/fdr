<?php

namespace AppBundle\Exception;

use Domain\Core\Exception\DomainException;
use Domain\Core\Exception\EntityNotFoundException;
use Domain\User\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;

final class ExceptionClassMap
{
    /** @var array */
    private $statusCodeMap = [
        AccessDeniedException::CLASS => Response::HTTP_FORBIDDEN,
        EntityNotFoundException::CLASS => Response::HTTP_NOT_FOUND,
        DomainException::CLASS => Response::HTTP_BAD_REQUEST,
    ];

    /** @var array */
    private $showMessages = [
        AccessDeniedException::CLASS,
        EntityNotFoundException::CLASS,
        DomainException::CLASS,
    ];

    /**
     * @param  string $class
     * @return int
     */
    public function getStatusCode($class)
    {
        foreach ($this->statusCodeMap as $keyClass => $statusCode) {
            if ($keyClass === $class || is_subclass_of($class, $keyClass)) {
                return $statusCode;
            }
        }

        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    /**
     * @param  string $class
     * @return boolean
     */
    public function canGetMessage($class)
    {
        foreach ($this->showMessages as $keyClass) {
            if ($keyClass === $class || is_subclass_of($class, $keyClass)) {
                return true;
            }
        }

        return false;
    }
}
