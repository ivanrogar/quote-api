<?php

declare(strict_types=1);

namespace App\Contract\Cache;

use Psr\Cache\InvalidArgumentException;

/**
 * Interface CacheTypeInterface
 * @package App\Contract\Cache
 */
interface CacheTypeInterface
{
    /**
     * @return string
     */
    public static function getName(): string;

    /**
     * @return bool
     */
    public function isEnabled(): bool;

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key);

    /**
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     * @return $this
     */
    public function set(string $key, $value, int $ttl = 86400);

    /**
     * @throws InvalidArgumentException
     */
    public function flush(): void;
}
