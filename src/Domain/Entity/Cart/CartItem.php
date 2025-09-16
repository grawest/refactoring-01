<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Domain\Entity\Cart;

final readonly class CartItem
{
    public function __construct(
        private string $productUuid,
        private float $price,
        private int $quantity,
    ) {
    }

    public function getProductUuid(): string
    {
        return $this->productUuid;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
