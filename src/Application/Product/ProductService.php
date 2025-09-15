<?php
declare(strict_types=1);

namespace Raketa\BackendTestTask\Application\Product;

use Raketa\BackendTestTask\Application\Interface\Repository\Product\ProductRepositoryInterface;
use Raketa\BackendTestTask\Domain\Entity\Product\ProductsCollection;

/**
 *
 */
class ProductService
{
    /**
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        private ProductRepositoryInterface $productRepository,
    )
    {
    }

    /**
     * @param string $category
     * @return ProductsCollection
     */
    public function getByCategory(string $category): ProductsCollection
    {
        return $this->productRepository->getByCategory($category);
    }
}
