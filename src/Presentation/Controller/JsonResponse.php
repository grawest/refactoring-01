<?php

declare(strict_types = 1);

namespace Raketa\BackendTestTask\Controller;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Класс заглушка
 */
final class JsonResponse implements ResponseInterface
{
    /**
     * @var int|mixed
     */
    private $statusCode = 200;
    /**
     * @var string
     */
    private $reasonPhrase = '';
    /**
     * @var string
     */
    private $protocolVersion = '1.1';
    /**
     * @var array
     */
    private $headers = [];
    /**
     * @var StreamInterface|Stream
     */
    private $body;
    /**
     * @var string[]
     */
    private $statusPhrases = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        204 => 'No Content',
        301 => 'Moved Permanently',
        302 => 'Found',
        304 => 'Not Modified',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
    ];

    /**
     * @param $statusCode
     * @param $body
     * @param array $headers
     */
    public function __construct($statusCode = 200, $body = null, array $headers = [])
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;

        if ($body instanceof StreamInterface) {
            $this->body = $body;
        } elseif (is_string($body)) {
            $this->body = new Stream(fopen('php://temp', 'r+'));
            $this->body->write($body);
            $this->body->rewind();
        } else {
            $this->body = new Stream(fopen('php://temp', 'r+'));
        }
    }

    /**
     * @return string
     */
    public function getProtocolVersion(): string
    {
        return $this->protocolVersion;
    }

    /**
     * @param $version
     * @return ResponseInterface
     */
    public function withProtocolVersion($version): ResponseInterface
    {
        $new = clone $this;
        $new->protocolVersion = $version;

        return $new;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasHeader($name): bool
    {
        return isset($this->headers[strtolower($name)]);
    }

    /**
     * @param $name
     * @return array
     */
    public function getHeader($name): array
    {
        $name = strtolower($name);

        return $this->headers[$name] ?? [];
    }

    /**
     * @param $name
     * @return string
     */
    public function getHeaderLine($name): string
    {
        return implode(', ', $this->getHeader($name));
    }

    /**
     * @param $name
     * @param $value
     * @return ResponseInterface
     */
    public function withHeader($name, $value): ResponseInterface
    {
        $new = clone $this;
        $name = strtolower($name);

        if (!is_array($value)) {
            $value = [$value];
        }

        $new->headers[$name] = $value;

        return $new;
    }

    /**
     * @param $name
     * @param $value
     * @return ResponseInterface
     */
    public function withAddedHeader($name, $value): ResponseInterface
    {
        $new = clone $this;
        $name = strtolower($name);

        if (!is_array($value)) {
            $value = [$value];
        }

        if (!isset($new->headers[$name])) {
            $new->headers[$name] = [];
        }

        $new->headers[$name] = array_merge($new->headers[$name], $value);

        return $new;
    }

    /**
     * @param $name
     * @return ResponseInterface
     */
    public function withoutHeader($name): ResponseInterface
    {
        $new = clone $this;
        $name = strtolower($name);
        unset($new->headers[$name]);

        return $new;
    }

    /**
     * @return StreamInterface
     */
    public function getBody(): StreamInterface
    {
        return $this->body;
    }

    /**
     * @param StreamInterface $body
     * @return ResponseInterface
     */
    public function withBody(StreamInterface $body): ResponseInterface
    {
        $new = clone $this;
        $new->body = $body;

        return $new;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param $code
     * @param $reasonPhrase
     * @return ResponseInterface
     */
    public function withStatus($code, $reasonPhrase = ''): ResponseInterface
    {
        $new = clone $this;
        $new->statusCode = (int) $code;

        if ($reasonPhrase === '' && isset($this->statusPhrases[$code])) {
            $reasonPhrase = $this->statusPhrases[$code];
        }

        $new->reasonPhrase = $reasonPhrase;

        return $new;
    }

    /**
     * @return string
     */
    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }
}
