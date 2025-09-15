<?php
declare(strict_types=1);

namespace Raketa\BackendTestTask\Domain\Entity\Dto;

/**
 *
 */
class AddToCartDto
{
    /**
     * @param string|null $cartId
     * @param string|null $productUuid
     * @param int|null $quantity
     */
    public function __construct(
        public ?string $cartId = null,
        public ?string $productUuid = null,
        public ?int $quantity = null,
    )
    {
    }

}
