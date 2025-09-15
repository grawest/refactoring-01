<?php

namespace Raketa\BackendTestTask\Controller\Cart;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\Application\Cart\CartService;
use Raketa\BackendTestTask\Controller\Common\Trait\ApiJsonResponse;
use Raketa\BackendTestTask\Controller\ValidationException;
use Raketa\BackendTestTask\Domain\Entity\Dto\AddToCartDto;
use Raketa\BackendTestTask\Infrastructure\Exceptions\CartException;
use Raketa\BackendTestTask\Output\Cart\CartOutputMapper;

/**
 * Контроллер добавления товара в корзину
 */
final readonly class AddToCartController
{
    use ApiJsonResponse;

    /**
     * @param CartService $cartService
     * @param CartOutputMapper $outputMapper
     */
    public function __construct(
        private CartService $cartService,
        private CartOutputMapper $outputMapper
    ) {
    }

    /**
     * @OA\Post(
     *     path="/api/v1/cart",
     *     tags={"Добавления товара в корзину"},
     *     description="Добавления товара в корзину",
     *     operationId="AddToCartController",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response="200",
     *         description="Товар добавлен в корзину"
     *     ),
     *     т.д....
     * )
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \JsonException
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $rawRequest = $request->getParsedBody();

            // Валидация. Бросаем исключение, если есть ошибка

            $cart = $this->cartService->addToCArt(new AddToCartDto(
                cartId: session_id(),
                productUuid: $rawRequest['productUuid'],
                quantity: $rawRequest['quantity'],
            ));

            return $this->jsonSuccess(
                $response, $this->outputMapper->toArray($cart), 'Товар добавлен в корзину'
            );

        } catch (ValidationException $e) {
            return $this->jsonError(
                $response, [$e->getTrace()], 'Ошибка валидации', 422
            );
        } catch (CartException $e) {
            return $this->jsonError(
                $response, [$e->getTrace()], $e->getMessage(), $e->getCode()
            );
        } catch (\Exception $e) {
            return $this->jsonError(
                $response, [$e->getTrace()], 'Ошибка', 500
            );
        }

    }
}
