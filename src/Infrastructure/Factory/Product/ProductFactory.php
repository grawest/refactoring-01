<?php
declare(strict_types=1);

namespace Raketa\BackendTestTask\Infrastructure\Factory\Products;

use Raketa\BackendTestTask\Domain\Entity\Product\Product;

class ProductFactory
{
    public static function createFromArray(array $row): Product
    {
        // Можно какие-то проверки сделать, валидацию

        return new Product(
            $row['id'],
            $row['uuid'],
            $row['is_active'],
            $row['category'],
            $row['name'],
            $row['description'],
            $row['thumbnail'],
            $row['price'],
        );
    }
}
