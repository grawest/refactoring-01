<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Infrastructure\Exceptions;

/**
 *
 */
class BaseException extends \Exception
{
    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf(
            '[%s] %s in %s on line %d',
            $this->getCode(),
            $this->getMessage(),
            $this->getFile(),
            $this->getLine(),
        );
    }
}
