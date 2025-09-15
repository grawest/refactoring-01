<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Repository;

use Doctrine\DBAL\Connection;
use Raketa\BackendTestTask\Application\Interface\Repository\Product\ProductRepositoryInterface;
use Raketa\BackendTestTask\Domain\Entity\Product\Product;
use Raketa\BackendTestTask\Domain\Entity\Product\ProductsCollection;
use Raketa\BackendTestTask\Infrastructure\Exceptions\ProductException;
use Raketa\BackendTestTask\Infrastructure\Factory\Products\ProductFactory;
use Raketa\BackendTestTask\Infrastructure\Factory\Products\ProductsFactory;

/**
 *
 */
class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var Connection
     */
    private Connection $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $uuid
     * @return Product
     * @throws ProductException
     */
    public function getByUuid(string $uuid): Product
    {
        // тут нужно через prepare сделать
        $row = $this->connection->fetchOne(
            "SELECT * FROM products WHERE uuid = " . $uuid,
        );

        if (empty($row)) {
            throw new ProductException('Product not found', 404, null);
        }

        return ProductFactory::createFromArray($row);
    }

    /**
     * @param string $category
     * @return ProductsCollection
     */
    public function getByCategory(string $category): ProductsCollection
    {
        // тут нужно через prepare сделать
        $rows = $this->connection->fetchAllAssociative(
            "SELECT id FROM products WHERE is_active = 1 AND category = " . $category,
        );

        return ProductsFactory::createFromArray($rows);
    }
}
