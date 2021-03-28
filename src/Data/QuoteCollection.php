<?php

declare(strict_types=1);

namespace App\Data;

use App\Contract\Data\QuoteCollectionInterface;
use App\Contract\Data\QuoteInterface;
use App\Contract\Search\CriteriaInterface;
use Webmozart\Assert\Assert;
use ArrayObject;

/**
 * Class QuoteCollection
 * @package App\Data
 * @SuppressWarnings(Static)
 * @SuppressWarnings(CamelCase)
 */
final class QuoteCollection implements QuoteCollectionInterface
{
    private CriteriaInterface $criteria;
    private ArrayObject $storage;

    /**
     * @inheritDoc
     */
    public function __construct(
        $quotes,
        CriteriaInterface $criteria
    ) {
        Assert::allImplementsInterface($quotes, QuoteInterface::class);

        $this->storage = new ArrayObject($quotes);

        $this->criteria = $criteria;
    }

    /**
     * @inheritDoc
     */
    public function getItems()
    {
        return $this->storage->getIterator();
    }

    /**
     * @inheritDoc
     */
    public function getCriteria(): CriteriaInterface
    {
        return $this->criteria;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $flat = [];

        /**
         * @var QuoteInterface $quote
         */
        foreach ($this->storage->getIterator() as $quote) {
            $flat[] = $quote->getText();
        }

        return $flat;
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return $this->storage->count();
    }
}
