<?php
declare(strict_types=1);

namespace Raketa\BackendTestTask\Domain\Entity\Product;

class ProductsCollection
{
    private array $items = [];

    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(Product $item): void
    {
        $this->items[] = $item;
    }
}
