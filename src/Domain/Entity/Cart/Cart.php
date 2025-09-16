<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Domain\Entity\Cart;

use Raketa\BackendTestTask\Domain\Entity\Customer\Customer;

final readonly class Cart
{
    public function __construct(
        private string $uuid,
        private Customer $customer,
        private string $paymentMethod,
        private array $items,
    ) {
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(CartItem $item): void
    {
        $this->items[] = $item;
    }
}
