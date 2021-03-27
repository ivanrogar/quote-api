<?php

declare(strict_types=1);

namespace App\Contract\Data;

use App\Contract\Search\CriteriaInterface;

/**
 * Interface CacheWranglerInterface
 * @package App\Contract\Data
 */
interface CacheWranglerInterface
{
    /**
     * @param CriteriaInterface $criteria
     * @return string
     */
    public function getCacheKey(CriteriaInterface $criteria): string;

    /**
     * @param CriteriaInterface $criteria
     * @return QuoteCollectionInterface|null
     */
    public function get(CriteriaInterface $criteria): ?QuoteCollectionInterface;

    /**
     * @param QuoteCollectionInterface $quoteCollection
     */
    public function dispatchToQueue(QuoteCollectionInterface $quoteCollection): void;
}
