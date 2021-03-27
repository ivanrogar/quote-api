<?php

declare(strict_types=1);

namespace App\Cache\Type;

use App\Contract\Cache\CacheTypeInterface;
use Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use Psr\Cache\CacheException;
use Psr\Cache\InvalidArgumentException;
use Psr\Log\LoggerInterface;

/**
 * Class AbstractType
 * @package App\Cache\Type
 * @SuppressWarnings(Static)
 */
abstract class AbstractType implements CacheTypeInterface
{
    protected TagAwareAdapterInterface $adapter;
    protected LoggerInterface $logger;

    /**
     * AbstractType constructor.
     * @param TagAwareAdapterInterface $adapter
     * @param LoggerInterface $logger
     */
    public function __construct(
        TagAwareAdapterInterface $adapter,
        LoggerInterface $logger
    ) {
        $this->adapter = $adapter;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function isEnabled(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function get(string $key)
    {
        if (!$this->isEnabled()) {
            return null;
        }

        $key = static::getName() . '_' . $key;

        try {
            $result = $this->adapter->getItem($key);
        } catch (InvalidArgumentException $exception) {
            $this
                ->logger
                ->error(
                    'Cache fetch failed in ' . get_class($this) . ' -> ' . $exception->getMessage(),
                    [
                        'key' => $key,
                    ]
                );

            return null;
        }

        return ($result->isHit()) ? $result->get() : null;
    }

    /**
     * @inheritDoc
     */
    public function set(string $key, $value, int $ttl = 86400)
    {
        if (!$this->isEnabled()) {
            return $this;
        }

        $key = static::getName() . '_' . $key;

        try {
            $item = $this->adapter->getItem($key);

            $item->expiresAfter($ttl);

            $item
                ->set($value)
                ->tag(static::getName());

            $this->adapter->save($item);
        } catch (InvalidArgumentException | CacheException $exception) {
            $this
                ->logger
                ->critical(
                    'Cache save failed in ' . get_class($this) . ' -> ' . $exception->getMessage(),
                    [
                        'value' => $value,
                    ]
                );
        }

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function flush(): void
    {
        $this->adapter->invalidateTags([static::getName()]);
    }
}
