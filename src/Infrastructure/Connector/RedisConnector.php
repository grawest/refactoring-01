<?php
declare(strict_types=1);

namespace Raketa\BackendTestTask\Infrastructure\Connector;

use Raketa\BackendTestTask\Infrastructure\Exceptions\RedisConnectorException;
use Redis;
use RedisException;

/**
 *
 */
class RedisConnector
{
    /**
     * @var Redis
     */
    private Redis $redis;

    /**
     * @param Redis $redis
     */
    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @param string $key
     * @return mixed
     * @throws RedisConnectorException
     */
    public function get(string $key): mixed
    {
        try {
            $data = $this->redis->get($key);
            return $data ? unserialize($data) : null;
        } catch (RedisException $e) {
            throw new RedisConnectorException(
                message: 'Connector error',
                code: $e->getCode(),
                previous: $e
            );
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     * @return void
     * @throws RedisConnectorException
     */
    public function set(string $key, mixed $value, int $ttl = 24 * 60 * 60): void
    {
        try {
            $this->redis->setex($key, $ttl, serialize($value));
        } catch (RedisException $e) {
            throw new RedisConnectorException('Connector error', $e->getCode(), $e);
        }
    }

    /**
     * @param string $key
     * @return bool
     * @throws RedisConnectorException
     */
    public function has(string $key): bool
    {
        try {
            return $this->redis->exists($key) > 0;
        } catch (RedisException $e) {
            throw new RedisConnectorException('Connector error', $e->getCode(), $e);
        }
    }
}
