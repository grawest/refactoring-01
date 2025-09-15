<?php
declare(strict_types = 1);

namespace Raketa\BackendTestTask\Repository;

use Exception;
use Psr\Log\LoggerInterface;
use Raketa\BackendTestTask\Application\Interface\Repository\Cart\CartRepositoryInterface;
use Raketa\BackendTestTask\Domain\Entity\Cart\Cart;
use Raketa\BackendTestTask\Infrastructure\Connector\RedisConnector;
use Raketa\BackendTestTask\Infrastructure\Exceptions\CartException;
use Raketa\BackendTestTask\Infrastructure\Exceptions\RedisConnectorException;

/**
 *
 */
class RedisCartRepository implements CartRepositoryInterface
{
    /**
     * @param RedisConnector $connector
     * @param LoggerInterface $logger
     */
    public function __construct(
        private RedisConnector $connector,
        private LoggerInterface $logger
    )
    {
    }

    /**
     * @param string $id
     * @param Cart $cart
     * @return void
     * @throws RedisConnectorException
     */
    public function save(string $id, Cart $cart): void
    {
        try {
            $this->connector->set($id, $cart);
        } catch (Exception $e) {
            $this->logger->error('Ошибка при сохранении корзины: ' . $e->getMessage(), ['Error' => $e]);

            throw $e;
        }
    }

    /**
     * @param string $id
     * @return Cart
     * @throws CartException
     * @throws RedisConnectorException
     */
    public function getById(string $id): Cart
    {
        try {
            $cart = $this->connector->get($id);
            if ($cart === null) {
                throw new CartException('Корзина отсутствует', 404, null);
            }

            return $cart;

        } catch (Exception $e) {
            $this->logger->error('Ошибка при получении корзины: ' . $e->getMessage(), ['Error' => $e]);

            throw $e;
        }
    }
}
