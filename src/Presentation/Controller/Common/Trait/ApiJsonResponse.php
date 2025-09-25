<?php
declare(strict_types=1);

namespace Raketa\BackendTestTask\Controller\Common\Trait;

use Psr\Http\Message\ResponseInterface as Response;


/**
 * JSON ответ
 */
trait ApiJsonResponse
{
    /**
     * Успех
     */
    protected function jsonSuccess(
        Response $response, $data = null, string $message = 'OK', int $status = 200
    ): Response
    {
        $payload = [
            'meta' => [
                'status' => $status,
                'message' => $message,
                'timestamp' => time()
            ],
            'data' => $data,
            'errors' => null
        ];

        return $this->withJson($response, $payload, $status);
    }

    /**
     * Ошибка 400
     */
    protected function jsonError(
        Response $response, array $errors, string $message = 'Ошибка', int $status = 400
    ): Response
    {
        $payload = [
            'meta' => [
                'status' => $status,
                'message' => $message,
                'timestamp' => time()
            ],
            'data' => null,
            'errors' => $errors,
            'pagination' => null
        ];

        return $this->withJson($response, $payload, $status);
    }

    /**
     * Ошибка 500
     *
     * @param Response $response
     * @param string $message
     * @return Response
     */
    protected function jsonServerError(
        Response $response, string $message = 'Внутренняя ошибка сервера'
    ): Response
    {
        $payload = [
            'meta' => [
                'status' => 500,
                'message' => $message,
                'timestamp' => time()
            ],
            'data' => null,
            'errors' => [['message' => $message]],
            'pagination' => null
        ];

        return $this->withJson($response, $payload, 500);
    }

    /**
     * @param Response $response
     * @param array $data
     * @param int $status
     * @return Response
     */
    private function withJson(
        Response $response, array $data, int $status = 200
    ): Response
    {
        $response = $response->withStatus($status);
        $response = $response->withHeader('Content-Type', 'application/json; charset=utf-8');

        $json = \json_encode($data, JSON_UNESCAPED_UNICODE);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $json = \json_encode([
                'meta' => [
                    'status' => 500,
                    'message' => 'Ошибка сериализации JSON',
                    'timestamp' => time()
                ],
                'data' => null,
                'errors' => [['message' => 'Внутренняя ошибка сериализации']],
            ]);
            $response = $response->withStatus(500);
        }

        $response->getBody()->write($json);
        return $response;
    }
}
