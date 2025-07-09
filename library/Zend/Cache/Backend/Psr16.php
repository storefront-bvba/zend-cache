<?php

declare(strict_types=1);

use Psr\SimpleCache\CacheInterface;

class Zend_Cache_Backend_Psr16 implements CacheInterface
{


    private Zend_Cache_Backend_ExtendedInterface $backend;

    public function __construct(Zend_Cache_Backend_ExtendedInterface $backend)
    {
        $this->backend = $backend;
    }


    public function get(string $key, mixed $default = null): mixed
    {
        $r = $this->backend->load($key);
        if ($r === false) {
            return $default;
        }
        return $r;
    }

    public function set(string $key, mixed $value, \DateInterval|int|null $ttl = null): bool
    {
        $ttl = $this->_conformTtl($ttl);
        return $this->backend->save($value, $key, [], $ttl);
    }

    public function delete(string $key): bool
    {
        return $this->backend->remove($key);
    }

    public function clear(): bool
    {
        return $this->backend->clean();
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        $r = [];
        foreach ($keys as $key) {
            $r[$key] = $this->get($key, $default);
        }
        return $r;
    }

    public function setMultiple(iterable $values, \DateInterval|int|null $ttl = null): bool
    {
        $ttl = $this->_conformTtl($ttl);
        foreach ($values as $key => $value) {
            $r = $this->backend->save($value, $key, [], $ttl);
            if ($r === false) {
                return false;
            }
        }
        return true;
    }

    public function deleteMultiple(iterable $keys): bool
    {
        foreach ($keys as $key) {
            $r = $this->delete($key);
            if ($r === false) {
                return false;
            }
        }
        return true;
    }

    public function has(string $key): bool
    {
        return $this->backend->test($key) !== null;
    }

    private function _conformTtl(DateInterval|int|null $ttl): ?int
    {
        if ($ttl instanceof \DateInterval) {
            $seconds = $ttl->days * 86400 + // days to seconds (24*60*60)
                $ttl->h * 3600 +     // hours to seconds (60*60)
                $ttl->i * 60 +       // minutes to seconds
                $ttl->s;             // seconds

            if ($ttl->f > 0) {
                $seconds += $ttl->f;
            }

            $ttl = (int)($ttl->invert ? -$seconds : $seconds);
        }
        return $ttl;
    }
}