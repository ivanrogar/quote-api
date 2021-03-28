<?php

declare(strict_types=1);

namespace App\Data\Provider;

use App\Contract\Data\CacheWranglerInterface;
use App\Contract\Data\Provider\QuoteProviderInterface;
use App\Contract\Data\QuoteCollectionInterface;
use App\Contract\Search\CriteriaInterface;
use App\Data\QuoteCollection;

/**
 * Class QuoteProvider
 * @package App\Data\Provider
 * @SuppressWarnings(Long)
 */
final class CacheProvider implements QuoteProviderInterface
{
    private CacheWranglerInterface $cacheWrangler;

    public const CODE = 'cache_provider';

    /**
     * LocalQuoteProvider constructor.
     * @param CacheWranglerInterface $cacheWrangler
     */
    public function __construct(
        CacheWranglerInterface $cacheWrangler
    ) {
        $this->cacheWrangler = $cacheWrangler;
    }

    /**
     * @inheritDoc
     */
    public function supports(CriteriaInterface $criteria): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getProviderCode(): string
    {
        return self::CODE;
    }

    /**
     * @inheritDoc
     */
    public function fetch(CriteriaInterface $criteria): QuoteCollectionInterface
    {
        return $this->cacheWrangler->get($criteria) ?: new QuoteCollection([], $criteria);
    }
}
