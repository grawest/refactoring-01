<?php
declare(strict_types=1);

namespace Raketa\BackendTestTask\Infrastructure\Factory\Redis;

use Raketa\BackendTestTask\Infrastructure\Connector\RedisConnector;
use Redis;

class ConnectorFactory
{
    public static function create(string $host, int $port, ?string $password, int $dbIndex): RedisConnector
    {
        $redis = new Redis();
        $redis->connect($host, $port);

        if ($password) {
            $redis->auth($password);
        }

        $redis->select($dbIndex);

        return new RedisConnector($redis);
    }
}
