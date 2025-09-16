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
        $sql = 'SELECT * FROM products WHERE uuid = ?';
        $row = $this->connection->fetchOne($sql, [$uuid]);

        if (empty($row)) {
            throw new ProductException('Товар не найден', 404, null);
        }

        return ProductFactory::createFromArray($row);
    }

    /**
     * @param string $category
     * @return ProductsCollection
     */
    public function getByCategory(string $category): ProductsCollection
    {
        $sql = 'SELECT * FROM products WHERE is_active = 1 AND category = ?';
        $rows = $this->connection->fetchAllAssociative($sql, [$category]);

        return ProductsFactory::createFromArray($rows);
    }

    /**
     * @param array $arUuids
     * @return ProductsCollection
     */
    public function getByUuids(array $arUuids): ProductsCollection
    {
        $strUuids = implode(',', $arUuids);
        $sql = 'SELECT * FROM users WHERE name IN (?)';
        $rows = $this->connection->fetchAllAssociative($sql, [$strUuids]);

        return ProductsFactory::createFromArray($rows);
    }
}
