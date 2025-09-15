<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Controller\Cart;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\Application\Cart\CartService;
use Raketa\BackendTestTask\Controller\Common\Trait\ApiJsonResponse;
use Raketa\BackendTestTask\Infrastructure\Exceptions\CartException;
use Raketa\BackendTestTask\Output\Cart\CartOutputMapper;


/**
 *
 */
final readonly class GetCartController
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
     *  @OA\Get(
     *     path="/api/v1/cart",
     *     tags={"Получить товары в корзине"},
     *     description="Получить товары в корзине",
     *     operationId="GetCartController",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response="200",
     *         description="Получить товары в корзине"
     *     ),
     *     т.д....
     * )
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $cart = $this->cartService->getById(session_id());
            return $this->jsonSuccess(
                $response, $this->outputMapper->toArray($cart), 'Товар добавлен в корзину'
            );
        } catch (CartException $e) {
            return $this->jsonError(
                $response, [$e->getTrace()], $e->getMessage(), $e->getCode()
            );
        } catch (\Exception $e) {
            return $this->jsonError(
                $response, [$e->getTrace()], $e->getMessage(), 500
            );
        }
    }
}
