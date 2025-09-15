<?php
declare(strict_types=1);

namespace Raketa\BackendTestTask\Application\Interface\Repository\Product;

use Raketa\BackendTestTask\Domain\Entity\Product\Product;
use Raketa\BackendTestTask\Domain\Entity\Product\ProductsCollection;

/**
 *
 */
interface ProductRepositoryInterface
{
    /**
     * @param string $uuid
     * @return Product
     */
    public function getByUuid(string $uuid): Product;

    /**
     * @param string $category
     * @return ProductsCollection
     */
    public function getByCategory(string $category): ProductsCollection;
}
