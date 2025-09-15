<?php
declare(strict_types=1);

namespace Raketa\BackendTestTask\Infrastructure\Common\UuidGenerator;

use Raketa\BackendTestTask\Application\Interface\Common\UuidGeneratorInterface;
use Ramsey\Uuid\Uuid;

/**
 *
 */
class RamseyUuidGenerator implements UuidGeneratorInterface
{
    /**
     * @return string
     */
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
