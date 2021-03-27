<?php

declare(strict_types=1);

namespace App\Data;

use App\Contract\Cache\CacheTypeInterface;
use App\Contract\Data\CacheWranglerInterface;
use App\Contract\Data\QuoteCollectionInterface;
use App\Contract\Search\CriteriaInterface;
use App\Message\QuoteMessage;
use Cocur\Slugify\Slugify;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class CacheWrangler
 * @package App\Data
 */
final class CacheWrangler implements CacheWranglerInterface
{
    private Slugify $slugify;
    private MessageBusInterface $messageBus;
    private CacheTypeInterface $cacheType;

    /**
     * CacheWrangler constructor.
     * @param Slugify $slugify
     * @param MessageBusInterface $messageBus
     * @param CacheTypeInterface $cacheType
     */
    public function __construct(
        Slugify $slugify,
        MessageBusInterface $messageBus,
        CacheTypeInterface $cacheType
    ) {
        $this->slugify = $slugify;
        $this->messageBus = $messageBus;
        $this->cacheType = $cacheType;
    }

    /**
     * Current choice is to cache results as "author slug-requested limit"
     * to avoid any re-processing/filtering when the data comes from cache
     * @inheritDoc
     */
    public function getCacheKey(CriteriaInterface $criteria): string
    {
        return $this->slugify->slugify($criteria->getAuthorSlug() . '-' . (string)$criteria->getLimit());
    }

    /**
     * @inheritDoc
     */
    public function get(CriteriaInterface $criteria): ?QuoteCollectionInterface
    {
        $cacheKey = $this->getCacheKey($criteria);

        $data = $this->cacheType->get($cacheKey);

        if ($data !== null) {
            return new QuoteCollection(unserialize($data), $criteria);
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function dispatchToQueue(QuoteCollectionInterface $quoteCollection): void
    {
        $cacheKey = $this->getCacheKey($quoteCollection->getCriteria());

        $message = new QuoteMessage(iterator_to_array($quoteCollection->getItems()), $cacheKey);

        $this->messageBus->dispatch($message);
    }
}
