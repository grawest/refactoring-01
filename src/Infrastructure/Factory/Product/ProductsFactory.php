<?php
declare(strict_types=1);

namespace Raketa\BackendTestTask\Infrastructure\Factory\Products;

use Raketa\BackendTestTask\Domain\Entity\Product\ProductsCollection;

class ProductsFactory
{
    public static function createFromArray(array $rows): ProductsCollection
    {
        // Можно какие-то проверки сделать, валидацию

        $products = new ProductsCollection();
        foreach ($rows as $row) {
            $products->addItem(ProductFactory::createFromArray($row));
        }
        return $products;
    }
}
