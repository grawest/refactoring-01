<?php
declare(strict_types=1);

namespace Raketa\BackendTestTask\Application\Cart;

use Raketa\BackendTestTask\Application\Interface\Common\UuidGeneratorInterface;
use Raketa\BackendTestTask\Application\Interface\Repository\Cart\CartRepositoryInterface;
use Raketa\BackendTestTask\Application\Interface\Repository\Product\ProductRepositoryInterface;
use Raketa\BackendTestTask\Domain\Entity\Cart\Cart;
use Raketa\BackendTestTask\Domain\Entity\Cart\CartItem;
use Raketa\BackendTestTask\Domain\Entity\Dto\AddToCartDto;
use Raketa\BackendTestTask\Infrastructure\Exceptions\RedisConnectorException;

/**
 *
 */
class CartService
{
    /**
     * @param ProductRepositoryInterface $productRepository
     * @param CartRepositoryInterface $cartRepository
     * @param UuidGeneratorInterface $uuidGenerator
     */
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private CartRepositoryInterface $cartRepository,
        private UuidGeneratorInterface $uuidGenerator,
    )
    {
    }

    /**
     * @param AddToCartDto $dto
     * @return Cart
     */
    public function addToCart(AddToCartDto $dto): Cart
    {
        $product = $this->productRepository->getByUuid($dto->productUuid);

        $cart = $this->getById($dto->cartId);
        $cart->addItem(new CartItem(
            $this->uuidGenerator->generate(),
            $product->getUuid(),
            $product->getPrice(),
            $dto->quantity,
        ));

        $this->cartRepository->save($dto->cartId, $cart);

        return $cart;
    }

    /**
     * @param string $id
     * @return Cart
     */
    public function getById(string $id): Cart
    {
        return $this->cartRepository->getById($id);
    }
}
