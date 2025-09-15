<?php
declare(strict_types=1);

namespace Raketa\BackendTestTask\Application\Interface\Repository\Cart;

use Raketa\BackendTestTask\Domain\Entity\Cart\Cart;
use Raketa\BackendTestTask\Infrastructure\Exceptions\CartException;
use Raketa\BackendTestTask\Infrastructure\Exceptions\RedisConnectorException;

/**
 *
 */
interface CartRepositoryInterface
{
    /**
     * @param string $id
     * @param Cart $cart
     * @return void
     */
    public function save(string $id, Cart $cart): void;

    /**
     * @param string $id
     * @return Cart
     * @throws CartException
     */
    public function getById(string $id): Cart;

}
