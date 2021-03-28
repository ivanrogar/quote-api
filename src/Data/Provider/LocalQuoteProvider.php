<?php

declare(strict_types=1);

namespace App\Data\Provider;

use App\Contract\Data\CacheWranglerInterface;
use App\Contract\Data\Provider\QuoteProviderInterface;
use App\Contract\Data\QuoteCollectionInterface;
use App\Contract\Repository\QuoteRepositoryInterface;
use App\Contract\Search\CriteriaInterface;
use App\Data\Transformer\EntityTransformer;

/**
 * Class QuoteProvider
 * @package App\Data\Provider
 * @SuppressWarnings(Long)
 */
final class LocalQuoteProvider implements QuoteProviderInterface
{
    private QuoteRepositoryInterface $quoteRepository;
    private EntityTransformer $transformer;
    private CacheWranglerInterface $cacheWrangler;

    public const CODE = 'local_quote_provider';

    /**
     * LocalQuoteProvider constructor.
     * @param QuoteRepositoryInterface $quoteRepository
     * @param EntityTransformer $transformer
     * @param CacheWranglerInterface $cacheWrangler
     */
    public function __construct(
        QuoteRepositoryInterface $quoteRepository,
        EntityTransformer $transformer,
        CacheWranglerInterface $cacheWrangler
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->transformer = $transformer;
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
        $quotes = $this->quoteRepository->getByCriteria($criteria);

        $collection = $this->transformer->transform($quotes, $criteria);

        $this->cacheWrangler->dispatchToQueue($collection);

        return $collection;
    }
}
