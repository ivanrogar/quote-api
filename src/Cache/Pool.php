<?php

declare(strict_types=1);

namespace App\Cache;

use App\Contract\Cache\CacheTypeInterface;

/**
 * Class Pool
 * @package App\Cache
 * @SuppressWarnings(Static)
 */
final class Pool
{
    /**
     * @var CacheTypeInterface[] $types
     */
    private iterable $types = [];

    /**
     * Pool constructor.
     * @param CacheTypeInterface[] $types
     */
    public function __construct(iterable $types = [])
    {
        $this->types = $types;
    }

    /**
     * @param array $filter
     * @return CacheTypeInterface[]
     */
    public function getMany(array $filter = [])
    {
        $types = [];

        foreach ($this->types as $type) {
            if (!empty($filter) && !in_array($type->getName(), $filter)) {
                continue;
            }

            $types[] = $type;
        }

        return $types;
    }

    /**
     * @param string $name
     * @return CacheTypeInterface|null
     */
    public function get(string $name): ?CacheTypeInterface
    {
        foreach ($this->types as $type) {
            if ($type::getName() === $name) {
                return $type;
            }
        }

        return null;
    }
}
