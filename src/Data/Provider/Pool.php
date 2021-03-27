<?php

declare(strict_types=1);

namespace App\Data\Provider;

use App\Contract\Data\Provider\QuoteProviderInterface;
use App\Contract\Data\QuoteCollectionInterface;
use App\Contract\Search\CriteriaInterface;

/**
 * Class Pool
 * @package App\Data\Provider
 * @SuppressWarnings(Static)
 */
final class Pool
{
    /**
     * @var QuoteProviderInterface[]
     */
    private iterable $providers = [];

    /**
     * Pool constructor.
     * @param QuoteProviderInterface[] $providers
     */
    public function __construct(iterable $providers = [])
    {
        $this->providers = $providers;
    }

    /**
     * Will traverse available providers and return first non-empty collection or null
     * @param CriteriaInterface $criteria
     * @return QuoteCollectionInterface|null
     */
    public function handle(CriteriaInterface $criteria): ?QuoteCollectionInterface
    {
        $collection = null;

        foreach ($this->providers as $provider) {
            if ($provider::supports($criteria)) {
                $collection = $provider->fetch($criteria);

                if ($collection->getCount()) {
                    break;
                }
            }
        }

        return $collection;
    }
}
