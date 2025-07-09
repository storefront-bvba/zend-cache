<?php

declare(strict_types=1);

class Zend_Cache_Backend_Redis extends Cm_Cache_Backend_Redis
{
    public static function create(string $host, int $port, int $dbNumber, ?string $password): self
    {
        $options = [
            'server' => $host,
            'port' => $port,
            'database' => $dbNumber,
            'persistent' => 'database' . $dbNumber,
            'password' => $password,
        ];

        return new self($options);
    }
}