<?php
declare(strict_types=1);

namespace Raketa\BackendTestTask\Infrastructure\Factory\Redis;

use Raketa\BackendTestTask\Infrastructure\Connector\RedisConnector;
use Raketa\BackendTestTask\Infrastructure\Exceptions\ConnectorFactoryException;
use Redis;

/**
 *
 */
class ConnectorFactory
{
    /**
     * @param string $host
     * @param int $port
     * @param string|null $password
     * @param int $dbIndex
     * @return RedisConnector
     * @throws ConnectorFactoryException
     * @throws \RedisException
     */
    public static function create(string $host, int $port, ?string $password, int $dbIndex): RedisConnector
    {
        $redis = new Redis();

        $isConnected = $redis->isConnected();
        if (!$isConnected) {
            $isConnected = $redis->connect($host, $port);
        }
        if (!$isConnected) {
            throw new ConnectorFactoryException('Connector factory error', 10);
        }

        if (
            $password !== null
            && !$redis->auth($password)
        ) {
            throw new ConnectorFactoryException('Connector factory error', 20);
        }

        if (!$redis->select($dbIndex)) {
            throw new ConnectorFactoryException('Connector factory error', 30);
        }

        $redis->ping();

        return new RedisConnector($redis);
    }
}
