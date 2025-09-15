<?php
declare(strict_types=1);

namespace Raketa\BackendTestTask\Output\Product;

use Raketa\BackendTestTask\Domain\Entity\Product\Product;
use Raketa\BackendTestTask\Domain\Entity\Product\ProductsCollection;

readonly class ProductOutputMapper
{
    public function __construct()
    {
    }

    public function toArray(ProductsCollection $products): array
    {
        $arResult = [];

        /** @var Product $product */
        foreach ($products->getItems() as $product) {
            $arResult[] = [
                'id' => $product->getId(),
                'uuid' => $product->getUuid(),
                'category' => $product->getCategory(),
                'description' => $product->getDescription(),
                'thumbnail' => $product->getThumbnail(),
                'price' => $product->getPrice(),
            ];
        }

        return $arResult;
    }
}
