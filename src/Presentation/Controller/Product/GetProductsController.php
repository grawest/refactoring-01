<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Controller\Product;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Raketa\BackendTestTask\Application\Product\ProductService;
use Raketa\BackendTestTask\Controller\Common\Trait\ApiJsonResponse;
use Raketa\BackendTestTask\Infrastructure\Exceptions\ProductException;
use Raketa\BackendTestTask\Output\Product\ProductOutputMapper;

/**
 *
 */
final readonly class GetProductsController
{
    use ApiJsonResponse;

    /**
     * @param ProductService $productService
     * @param ProductOutputMapper $outputMapper
     */
    public function __construct(
        private ProductService $productService,
        private ProductOutputMapper $outputMapper
    ) {
    }

    /**
     *  @OA\Get(
     *     path="/api/v1/product/category",
     *     tags={"Получить товары в категории"},
     *     description="Получить товары в категории",
     *     operationId="GetProductsController",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="category",
     *         description="Категория",
     *         @OA\Schema(
     *             type="string"
     *         ),
     *         in="path",
     *         required=true
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Получить товары в категории"
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
            $rawRequest = $request->getParsedBody();

            // Валидация. Бросаем исключение, если есть ошибка

            $products = $this->productService->getByCategory($rawRequest['category']);

            return $this->jsonSuccess(
                $response, $this->outputMapper->toArray($products), 'Товары в категории'
            );
        } catch (ValidationException $e) {
            return $this->jsonError(
                $response, [$e->getTrace()], 'Ошибка валидации', 422
            );
        } catch (ProductException $e) {
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
