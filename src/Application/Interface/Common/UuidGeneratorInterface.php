<?php
declare(strict_types=1);

namespace Raketa\BackendTestTask\Application\Interface\Common;

/**
 *
 */
interface UuidGeneratorInterface
{
    /**
     * @return string
     */
    public function generate(): string;
}
